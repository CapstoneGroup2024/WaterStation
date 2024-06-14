<?php
session_start();
include('config/dbconnect.php');

file_put_contents('debug.txt', print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];
    $product_id = $_POST['product_id'];

    // Ensure the user is logged in and the user ID is set in the session
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['message'] = 'User not logged in';
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Check if the product is in the user's cart
    $quantity_sql = "SELECT quantity FROM cart_items WHERE user_id = ? AND id = ? AND product_id = ?";
    $stmt = $con->prepare($quantity_sql);
    $stmt->bind_param("iii", $user_id, $cart_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check for errors in SQL execution
    if (!$result) {
        $_SESSION['message'] = "Error fetching cart item: " . mysqli_error($con);
        $_SESSION['success'] = false;
        echo json_encode(['success' => false, 'message' => $_SESSION['message']]);
        exit();
    }
    
    if (mysqli_num_rows($result) > 0) {
        // Fetch product quantity
        $availableStockQuery = "SELECT quantity FROM product WHERE id = ?";
        $stmt_stock = $con->prepare($availableStockQuery);
        $stmt_stock->bind_param("i", $product_id);
        $stmt_stock->execute();
        $stockResult = $stmt_stock->get_result();

        // Check for errors in SQL execution
        if (!$stockResult) {
            $_SESSION['message'] = "Error fetching product quantity: " . mysqli_error($con);
            $_SESSION['success'] = false;
            echo json_encode(['success' => false, 'message' => $_SESSION['message']]);
            exit();
        }

        // Check if the product exists
        if (mysqli_num_rows($stockResult) > 0) {
            $stockData = mysqli_fetch_assoc($stockResult);
            $availableStock = $stockData['quantity'];

            // Check if the selected quantity exceeds the available stock
            if ($quantity > $availableStock) {
                $_SESSION['message'] = "Sorry, the selected quantity exceeds the available stock.";
                echo json_encode(['success' => false, 'message' => 'Selected quantity exceeds available stock']);
                exit();
            }

            // Update the quantity of the product in the cart
            $sql = "UPDATE cart_items SET quantity = ? WHERE user_id = ? AND id = ? AND product_id = ?";
            $stmt_update = $con->prepare($sql);
            $stmt_update->bind_param("iiii", $quantity, $user_id, $cart_id, $product_id);
            $stmt_update->execute();

            if ($stmt_update->affected_rows > 0) {
                // Calculate the difference in quantity
                $row = mysqli_fetch_assoc($result);
                $quantityDifference = $quantity - $row['quantity'];

                // Update product quantity
                $newStock = $availableStock - $quantityDifference;
                $updateStockQuery = "UPDATE product SET quantity = ? WHERE id = ?";
                $updateStmt = $con->prepare($updateStockQuery);
                $updateStmt->bind_param("ii", $newStock, $product_id);
                $updateStmt->execute();

                if ($updateStmt->affected_rows > 0) {
                    $_SESSION['message'] = "✔ Quantity updated successfully";
                    $_SESSION['success'] = true;
                    echo json_encode(['success' => true, 'message' => 'Quantity updated successfully']);
                    exit();
                } else {
                    $_SESSION['message'] = "✘ Failed to update product quantity";
                    $_SESSION['success'] = false;
                    echo json_encode(['success' => false, 'message' => 'Failed to update product quantity']);
                    exit();
                }
            } else {
                $_SESSION['message'] = "✘ Failed to update quantity";
                $_SESSION['success'] = false;
                echo json_encode(['success' => false, 'message' => 'Failed to update quantity']);
                exit();
            }
        } else {
            $_SESSION['message'] = "Product not found";
            $_SESSION['success'] = false;
            echo json_encode(['success' => false, 'message' => 'Product not found']);
            exit();
        }
    } else {
        $_SESSION['message'] = "Cart item not found";
        $_SESSION['success'] = false;
        echo json_encode(['success' => false, 'message' => 'Cart item not found']);
        exit();
    }
} else {
    $_SESSION['message'] = 'Invalid request method';
    $_SESSION['success'] = false;
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}
?>
