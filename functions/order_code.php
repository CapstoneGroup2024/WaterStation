<?php
session_start();
include('../config/dbconnect.php');
include('../functions/myAlerts.php');

function getItemsCart($userId) {
    global $con; 

    // QUERY TO SELECT CART ITEMS FOR A SPECIFIC USER
    $query = "SELECT * FROM cart_items WHERE user_id = '$userId'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return $result; // Return the result set
    } else {
        // DISPLAY ERROR MESSAGE IF QUERY FAILED
        echo "Error retrieving cart items: " . mysqli_error($con);
        return false;
    }
}
 
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
    $quantity = isset($_POST['selectedQuantity']) ? $_POST['selectedQuantity'] : 1; // DEFAULT QUANTITY IS 1
    $availableStockQuery = "SELECT quantity FROM product WHERE id='$productId'";
    
    $stockResult = mysqli_query($con, $availableStockQuery);
    if ($stockResult) {
        $stockData = mysqli_fetch_assoc($stockResult);
        $availableStock = $stockData['quantity'];
    
        // Check if the selected quantity exceeds the available stock
        if ($quantity > $availableStock) {
            $_SESSION['message'] = "Sorry, the selected quantity exceeds the available stock.";
            header('Location: ../order.php');
            exit;
        }
    } else {
        // Handle the case when unable to fetch stock data
        $_SESSION['message'] = "Failed to fetch stock data.";
        header('Location: ../order.php');
        exit;
    }
    

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
} else if (isset($_POST['placeOrderBtn'])) {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['message'] = "Please log in to add items to your cart.";
        header('Location: ../homepage.php');
        exit;
    }

    // Retrieve userID
    $userId = $_SESSION['user_id'];

    // Retrieve order details from POST request (sanitize input)
    $subtotal = $_POST['subtotal'];
    $additionalFee = $_POST['additional_fee'];
    $grandTotal = $_POST['grandtotal'];

    // Assign status
    $status = 'Ongoing';

    // Insert order into the orders table using prepared statement
    $insertOrderQuery = "INSERT INTO orders (user_id, status, subtotal, additional_fee, grand_total) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insertOrderQuery);
    mysqli_stmt_bind_param($stmt, "isddd", $userId, $status, $subtotal, $additionalFee, $grandTotal);
    $insertOrderSuccess = mysqli_stmt_execute($stmt);

    if ($insertOrderSuccess) {
        // Retrieve the orderID generated by the database
        $orderId = mysqli_insert_id($con);

        // Set order details in sessions
        $_SESSION['order_id'] = $orderId;
        $_SESSION['subtotal'] = $subtotal;
        $_SESSION['additional_fee'] = $additionalFee;
        $_SESSION['grandtotal'] = $grandTotal;

        // Loop through the cart items
        $cartItems = getItemsCart($userId);

        // Start transaction
        mysqli_autocommit($con, false);

        $orderItemsSuccess = true;
        foreach ($cartItems as $cart) {
            $productId = $cart['product_id'];
            $quantity = $cart['quantity'];
            $price = $cart['selling_price'];
            $total = $price * $quantity; // Calculate total for the item

            // Insert each product into the order items table
            $insertOrderItemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price, total) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $insertOrderItemQuery);
            mysqli_stmt_bind_param($stmt, "iiidi", $orderId, $productId, $quantity, $price, $total);
            $orderItemsSuccess = mysqli_stmt_execute($stmt);

            // If insertion fails, rollback and break the loop
            if (!$orderItemsSuccess) {
                mysqli_rollback($con);
                break;
            }
        }

        // Commit or rollback transaction
        // Commit or rollback transaction
        if ($orderItemsSuccess) {
            // Subtract ordered quantity from product quantity in the product table
            foreach ($cartItems as $cart) {
                $productId = $cart['product_id'];
                $quantity = $cart['quantity'];
        
                // Update product quantity in the product table
                $updateProductQuery = "UPDATE product SET quantity = quantity - ? WHERE id = ?";
                $stmt = mysqli_prepare($con, $updateProductQuery);
                mysqli_stmt_bind_param($stmt, "ii", $quantity, $productId);
                $updateSuccess = mysqli_stmt_execute($stmt);
        
                // If update fails, rollback and break the loop
                if (!$updateSuccess) {
                    mysqli_rollback($con);
                    $_SESSION['message'] = "Failed to update product quantity.";
                    header('Location: ../cart.php');
                    exit;
                }
            }
        
            // Delete cart items after successfully adding to order items
            $deleteCartItemsQuery = "DELETE FROM cart_items WHERE user_id = ?";
            $stmt = mysqli_prepare($con, $deleteCartItemsQuery);
            mysqli_stmt_bind_param($stmt, "i", $userId);
            $deleteCartItemsSuccess = mysqli_stmt_execute($stmt);
        
            // If deletion fails, rollback
            if (!$deleteCartItemsSuccess) {
                mysqli_rollback($con);
                $_SESSION['message'] = "Failed to delete cart items.";
                header('Location: ../cart.php');
                exit;
            }
        
            mysqli_commit($con);
            $_SESSION['message'] = "Order placed successfully. Order ID: $orderId, Subtotal: $subtotal, Additional Fee: $additionalFee, Grand Total: $grandTotal";
            unset($_SESSION['cart']); // Clear the cart after successful order placement
            header('Location: ../payment.php?id=' . $orderId);
            exit;
        } else {
            mysqli_rollback($con);
            $_SESSION['message'] = "Failed to add order items.";
            header('Location: ../cart.php');
            exit;
        }
        

    } else {
        // Order insertion failed
        $_SESSION['message'] = "Failed to place order.";
        header('Location: ../cart.php');
        exit;
    }
}
