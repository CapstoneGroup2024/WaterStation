<?php
session_start();
include('config/dbconnect.php');

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
    
    if (mysqli_num_rows($result) > 0) {
        
        $availableStockQuery = "SELECT quantity FROM product WHERE id='$product_id'";
    
        $stockResult = mysqli_query($con, $availableStockQuery);
        if ($stockResult) {
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
            $stmt = $con->prepare($sql);
            $stmt->bind_param("iiii", $quantity, $user_id, $cart_id, $product_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['message'] = "✔ Quantity updated successfully";
                $_SESSION['success'] = true; 
                echo json_encode(['success' => true, 'message' => 'Quantity updated successfully']);
                exit();
            } else {
                $_SESSION['message'] = "✘ Failed to update quantity";
                $_SESSION['success'] = false; 
                echo json_encode(['success' => false, 'message' => 'Failed to update quantity']);
                exit();
            }

        } else {
            // Handle the case when unable to fetch stock data
            $_SESSION['message'] = "✘ Failed to fetch stock data.";
            $_SESSION['success'] = false; 
            echo json_encode(['success' => false, 'message' => 'Failed to fetch stock data']);
            exit();
        }
    } else {
        $_SESSION['message'] = "Product not found in the cart.";
        $_SESSION['success'] = false; 
        echo json_encode(['success' => false, 'message' => 'Product not found in the cart']);
        exit();
    }
} else {
    $_SESSION['message'] = 'Invalid request method';
    $_SESSION['success'] = false; 
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}
?>
