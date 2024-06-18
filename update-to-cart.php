<?php
session_start();
include('config/dbconnect.php');

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];
    $product_id = $_POST['product_id'];

    // Ensure the user is logged in and the user ID is set in the session
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit();
    }

    $user_id = $_SESSION['user_id'];
    

    // Fetch current quantity from cart_items
    $stmt = $con->prepare("SELECT quantity FROM cart_items WHERE user_id = ? AND id = ? AND product_id = ?");
    $stmt->bind_param("iii", $user_id, $cart_id, $product_id);
    $stmt->execute();
    $stmt->bind_result($currentQuantity);
    $stmt->fetch();
    $stmt->close();
    
    // Calculate quantity difference
    $quantityDifference = $quantity - $currentQuantity;

    // Begin transaction for data consistency
    $con->begin_transaction();

    try {
        if ($quantityDifference > 0) {
            $message = increase_order_quantity($cart_id, $product_id, $quantityDifference, $con);
        } elseif ($quantityDifference < 0) {
            $message = decrease_order_quantity($cart_id, $product_id, -$quantityDifference, $con);
        } else {
            // Quantity unchanged
            $message = "Order quantity unchanged";
        }

        // Commit transaction if all queries succeed
        $con->commit();

        echo json_encode(['success' => true, 'message' => $message]);
    } catch (Exception $e) {
        // Rollback transaction on failure
        $con->rollback();
        echo json_encode(['success' => false, 'message' => 'Transaction failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Function to increase order quantity
// Function to increase order quantity
function increase_order_quantity($cart_id, $product_id, $quantityDifference, $con) {
    // Fetch current product quantity
    $productquery = "SELECT quantity FROM product WHERE id = $product_id";
    $productQuantityResult = mysqli_query($con, $productquery);
    
    if (!$productQuantityResult) {
        // Handle query error (optional)
        return json_encode(['success' => false, 'message' => 'Database error']);
    }

    $productQuantityRow = mysqli_fetch_assoc($productQuantityResult);
    $productQuantity = $productQuantityRow['quantity'];

    // Check if there's enough stock to increase the order quantity
    if ($productQuantity <= 0) {
        return json_encode(['success' => false, 'message' => 'No stocks']);
    }

    // Update cart_items table
    $stmt = $con->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE user_id = ? AND id = ? AND product_id = ?");
    $stmt->bind_param("iiii", $quantityDifference, $_SESSION['user_id'], $cart_id, $product_id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        // Update product quantity
        update_product_quantity($product_id, -$quantityDifference, $con);
        return json_encode(['success' => true, 'message' => 'Order quantity increased']);
    } else {
        return json_encode(['success' => false, 'message' => 'Failed to increase order quantity']);
    }
}


// Function to decrease order quantity
function decrease_order_quantity($cart_id, $product_id, $quantityDifference, $con) {
    // Update cart_items table
    $stmt = $con->prepare("UPDATE cart_items SET quantity = quantity - ? WHERE user_id = ? AND id = ? AND product_id = ?");
    $stmt->bind_param("iiii", $quantityDifference, $_SESSION['user_id'], $cart_id, $product_id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        // Update product quantity
        update_product_quantity($product_id, $quantityDifference, $con);
        return "Order quantity decreased";
    } else {
        throw new Exception("Failed to decrease order quantity");
    }
}

// Function to update product quantity
function update_product_quantity($product_id, $quantityDifference, $con) {
    $stmt = $con->prepare("UPDATE product SET quantity = quantity + ? WHERE id = ?");
    $stmt->bind_param("ii", $quantityDifference, $product_id);
    $stmt->execute();
}
?>
