<?php
session_start();
include('config/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Ensure the user is logged in and the user ID is set in the session
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['message'] = 'User not logged in';
        header('Location: cart.php'); // Redirect back to the cart page
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Check if the product is in the user's cart
    $quantity_sql = "SELECT quantity FROM cart_items WHERE user_id = ? AND id = ?";
    $stmt = $con->prepare($quantity_sql);
    $stmt->bind_param("ii", $user_id, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if (mysqli_num_rows($result) > 0) {
        // Update the quantity of the product in the cart
        $sql = "UPDATE cart_items SET quantity = ? WHERE user_id = ? AND id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iii", $quantity, $user_id, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = '✔ Quantity updated successfully';
        } else {
            $_SESSION['message'] = '✖ Failed to update quantity';
        }
    } else {
        $_SESSION['message'] = "✖ Product not found in the cart.";
    }

    $stmt->close();
    $conn->close();

    header('Location: cart.php'); // Redirect back to the cart page
    exit();
} else {
    $_SESSION['message'] = 'Invalid request method';
    header('Location: cart.php'); // Redirect back to the cart page
    exit();
}
?>
