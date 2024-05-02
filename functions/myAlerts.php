<?php
    include('../config/dbconnect.php');
    session_start();
    function getData($table){ // FETCH DATA FROM SPECIFIC TABLE
        global $con; // ACCESS GLOBAL DATABASE VARIABLE
        $query = "SELECT * FROM $table"; // SQL QUERY O SELECT ALL DATA FROM THE TABLE
        return $query_run = mysqli_query($con, $query); // EXECUTE QUERY AND RETURN RESULT
    }
    function getByID($table, $id){ // FETCH DATA FROM SPECIFIC TABLE BASED ON ID
        global $con; // ACCESS GLOBAL DATABASE VARIABLE
        $query = "SELECT * FROM $table WHERE id='$id'"; // SQL QUERY O SELECT ALL DATA FROM THE TABLE WHERE ID MATCHES THE PROVIDED ID
        return $query_run = mysqli_query($con, $query); // EXECUTE QUERY AND RETURN RESULT
    }
    function redirect($url, $message){ // PASS URL AND MESSAGE PARAMETERS
        $_SESSION['message'] = $message; // MESSAGE
        header('Location: '.$url); // REDIRECT
        exit();
    }
// Function to add a product to the cart
    function addToCart($productId, $categoryId, $quantity) {
        // Initialize or retrieve the shopping cart array from the session
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

        // Create a unique identifier for the product in the cart
        $cartItemId = $productId . '_' . $categoryId;

        // Check if the product is already in the cart
        if(isset($cart[$cartItemId])) {
            // If it is, update the quantity
            $cart[$cartItemId]['quantity'] += $quantity;
        } else {
            // If it's not, add a new item to the cart
            $cart[$cartItemId] = array(
                'productId' => $productId,
                'categoryId' => $categoryId,
                'quantity' => $quantity
            );
        }
        // Update the cart in the session
        $_SESSION['cart'] = $cart;
    }
?>