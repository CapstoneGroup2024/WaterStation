<?php
session_start();
include('../config/dbconnect.php');
include('../functions/myAlerts.php');
 
if(isset($_POST['cartBtn'])){ // CHECK IF THE 'cartBtn' IS SET IN THE POST REQUEST
   
    // RETRIEVE SELECTED PRODUCT, CATEGORY, AND QUANTITY FROM POST REQUEST
    if(!isset($_SESSION['user_id'])){
        $_SESSION['message'] = "Please log in to add items to your cart.";
        header('Location: ../homepage.php');
        exit; // Terminate further execution
    }

    $userId = $_SESSION['user_id'];

    // Retrieve product and category data
    $productId = isset($_POST['selectedProduct']) ? $_POST['selectedProduct'] : 1;
    $categoryId = isset($_POST['selectedCategory']) ? $_POST['selectedCategory'] : 1;
    $quantity = isset($_POST['quantityInput']) ? $_POST['quantityInput'] : 1; // DEFAULT QUANTITY IS 1

    if(empty($productId) || empty($categoryId)){ // CHECK IF PRODUCT ID OR CATEGORY ID IS EMPTY
        $_SESSION['message'] = "Please choose a product/category!";
        header('Location: ../order.php');
        exit; // Terminate further execution
    } else {
        // FETCH PRODUCT AND CATEGORY DATA FROM DATABASE
        $product_query = "SELECT * FROM product WHERE id = '$productId'";
        $category_query = "SELECT * FROM categories WHERE id = '$categoryId'";

        $product_result = mysqli_query($con, $product_query);
        $category_result = mysqli_query($con, $category_query);

        $product = mysqli_fetch_assoc($product_result);
        $category = mysqli_fetch_assoc($category_result);

        // STORE CART ITEM DETAILS IN AN ARRAY
        $cartItem = array(
            'productId' => $productId,
            'productName' => $product['name'],
            'productImage' => $product['image'],
            'sellingPrice' => $product['selling_price'],
            'categoryId' => $categoryId,
            'categoryName' => $category['name'],
            'additionalPrice' => $category['additional_price'],
            'quantity' => $quantity
        );

        // INSERT CART ITEM INTO DATABASE TABLE
        if($userId){
            // Insert cart item into the database table
            $insert_query = "INSERT INTO cart_items (user_id, product_id, product_name, product_image, selling_price, category_id, category_name, additional_price, quantity) 
                             VALUES ('$userId', '$productId', '{$product['name']}', '{$product['image']}', '{$product['selling_price']}', '$categoryId', '{$category['name']}', '{$category['additional_price']}', '$quantity')";
            $insert_query_run = mysqli_query($con, $insert_query);

                // Check if the query executed successfully
                if($insert_query_run){
                    $_SESSION['message'] = "ITEM ADDED TO CART SUCCESSFULLY!";
                    header('Location: ../cart.php');  
                      
                } else {
                    $_SESSION['message'] = "Error: " . mysqli_error($con); // Get detailed error message
                    header('Location: ../register.php');
                }
        } else {
            // Handle the case when product or category data cannot be fetched
            $_SESSION['message'] = "Failed to fetch product or category data.";
            header('Location: ../admin/index.php');
        }
    }
} else if(isset($_POST['deleteOrderBtn'])){
    foreach($_POST as $key => $value) {
        if (strpos($key, 'cart_id') === 0) {
            $cart_id = mysqli_real_escape_string($con, $value);

            $cart_query = "SELECT * FROM cart_items WHERE id='$cart_id'";
            $cart_query_run = mysqli_query($con, $cart_query);
            $cart_data = mysqli_fetch_array($cart_query_run);

            // Delete the cart item
            $delete_query = "DELETE FROM cart_items WHERE id='$cart_id'";
            $delete_query_run = mysqli_query($con, $delete_query);

            if($delete_query_run){
                $_SESSION['message'] = "✔ Cart Item Deleted Successfully";
                header('Location: ../cart.php');
                exit; // Terminate further execution
            } else{
                $_SESSION['message'] = "Something went wrong";
                header('Location: ../cart.php');
                exit; // Terminate further execution
            }
        }
    }
} else if(isset($_POST['placeOrderBtn'])){
    // RETRIEVE SELECTED PRODUCT, CATEGORY, AND QUANTITY FROM POST REQUEST
    if(!isset($_SESSION['user_id'])){
        $_SESSION['message'] = "Please log in to add items to your cart.";
        header('Location: ../homepage.php');
        exit; // Terminate further execution
    }

    $userId = $_SESSION['user_id'];

    $subtotal = $_POST['subtotal'];
    $additional_fee = $_POST['additional_fee'];
    $grandtotal = $_POST['grandtotal'];

    $insert_query = "INSERT INTO orders (user_id, status, subtotal, additional_fee, grand_total) VALUES ('$userId', 'Ongoing', '$subtotal', '$additional_fee', '$grandtotal')";
    $insert_query_run = mysqli_query($con, $insert_query);

    if($insert_query_run){
        $_SESSION['message'] = "✔ Order in Process. Subtotal: $subtotal, $additional_fee, $grandtotal";
        header('Location: ../payment.php');
        exit; // Terminate further execution
    } else {
        $_SESSION['message'] = "Something went wrong";
        header('Location: ../cart.php');
        exit; // Terminate further execution
    }

}


