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

    // Retrieve product, category, and quantity data
    $productId = isset($_POST['selectedProduct']) ? $_POST['selectedProduct'] : null;
    $categoryId = isset($_POST['selectedCategory']) ? $_POST['selectedCategory'] : null;
    $quantity = isset($_POST['selectedQuantity']) ? $_POST['selectedQuantity'] : 1; // DEFAULT QUANTITY IS 1

    // Validate if product and category are selected
    if(empty($productId) || empty($categoryId)){ // CHECK IF PRODUCT ID OR CATEGORY ID IS EMPTY
        $_SESSION['message'] = "Please choose both a product and a category!";
        header('Location: ../order.php');
        exit; // Terminate further execution
    }

    // Check if the same product and category already exists in cart_items
    $productCheck = "SELECT * FROM cart_items WHERE user_id='$userId' AND product_id='$productId' AND category_id='$categoryId'";
    $productCheck_query = mysqli_query($con, $productCheck);
    
    if ($productCheck_query) {
        if (mysqli_num_rows($productCheck_query) > 0) {
            // Product with the same category exists in cart_items
            $_SESSION['message'] = "This item is already in your cart.";
            header('Location: ../order.php');
            exit;
        }
    } else {
        $_SESSION['message'] = "Error checking existing product in cart: " . mysqli_error($con);
        header('Location: ../order.php');
        exit;
    }
    
    // If everything is valid, proceed to insert the item into cart_items
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
        'product_quantity' => $product['quantity'],
        'categoryId' => $categoryId,
        'categoryName' => $category['name'],
        'additionalPrice' => $category['additional_price'],
        'quantity' => $quantity
    );

    // INSERT CART ITEM INTO DATABASE TABLE
    if($userId){
        $insert_query = "INSERT INTO cart_items (user_id, product_id, product_name, product_image, selling_price, category_id, category_name, additional_price, quantity) 
                        VALUES ('$userId', '$productId', '{$product['name']}', '{$product['image']}', '{$product['selling_price']}', '$categoryId', '{$category['name']}', '{$category['additional_price']}', '$quantity')";
        $insert_query_run = mysqli_query($con, $insert_query);

        if ($insert_query_run) {
            // Update product quantity in the product table
            $updateProductQuery = "UPDATE product SET quantity = quantity - ? WHERE id = ?";
            $stmt = mysqli_prepare($con, $updateProductQuery);
            mysqli_stmt_bind_param($stmt, "ii", $quantity, $productId);
            $updateSuccess = mysqli_stmt_execute($stmt);

            if ($updateSuccess) {
                $_SESSION['message'] = "ITEM ADDED TO CART SUCCESSFULLY!";
                header('Location: ../cart.php');
                exit;
            } else {
                $_SESSION['message'] = "Failed to update product quantity.";
                header('Location: ../order.php');
                exit;
            }
        } else {
            $_SESSION['message'] = "Error adding item to cart: " . mysqli_error($con);
            header('Location: ../order.php');
            exit;
        }
    } else {
        // Handle the case when product or category data cannot be fetched
        $_SESSION['message'] = "Failed to fetch product or category data.";
        header('Location: ../admin/index.php');
    }
}
 else if(isset($_POST['deleteOrderBtn'])){
    $cart_id = $_POST['cart_id'];

    foreach($_POST as $key => $value) {
        if (strpos($key, 'cart_id') === 0) {
            $cart_id = mysqli_real_escape_string($con, $value);

            $updateProductQuantities = "UPDATE product p
                    INNER JOIN cart_items ci ON p.id = ci.product_id
                    SET p.quantity = p.quantity + ci.quantity
                    WHERE ci.id = '$cart_id'";
            $updateProductQuantitiesResult = mysqli_query($con, $updateProductQuantities);

            $cart_query = "SELECT * FROM cart_items WHERE id='$cart_id'";
            $cart_query_run = mysqli_query($con, $cart_query);
            $cart_data = mysqli_fetch_array($cart_query_run);

            // Delete the cart item
            $delete_query = "DELETE FROM cart_items WHERE id='$cart_id'";
            $delete_query_run = mysqli_query($con, $delete_query);

            if($updateProductQuantitiesResult && $delete_query_run){
                $_SESSION['message'] = "✔ Cart Item Deleted Successfully";
                header('Location: ../cart.php');
                exit; 
            } else{
                if(!$updateProductQuantitiesResult || !$delete_query_run) {
                    $_SESSION['message'] = "Error: " . mysqli_error($con);
                } else {
                    $_SESSION['message'] = "Something went wrong";
                }
                header('Location: ../cart.php');
                exit; 
            }
        }
    }
} else if(isset($_POST['placeOrderBtn'])) {
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
} else if(isset($_POST['cancelOrderBtn'])){
    $order_id = $_POST['order_id'];

    $updateQuery = "UPDATE orders SET status = 'Cancelled' WHERE id = ?";
    $statement = mysqli_prepare($con, $updateQuery);

    // Bind the parameter and execute the statement
    mysqli_stmt_bind_param($statement, "i", $order_id);
    $result = mysqli_stmt_execute($statement);

    // Insert necessary data into the order_transac table
    $insertQuery = "INSERT INTO order_transac (order_id, user_id, user_name, phone, address, product_id, product_name, quantity, price, total, status, subtotal, additional_fee, grand_total, order_at)
                    SELECT
                        o.id AS order_id,
                        u.user_id AS user_id,
                        u.name AS user_name,
                        u.phone AS phone,
                        u.address AS address,
                        oi.product_id AS product_id,
                        p.name AS product_name,
                        oi.quantity AS quantity,
                        p.selling_price AS price,
                        (oi.quantity * p.selling_price) AS total,
                        o.status AS status,
                        o.subtotal AS subtotal,
                        o.additional_fee AS additional_fee,
                        o.grand_total AS grand_total,
                        o.order_at AS order_at
                    FROM
                        orders o
                    INNER JOIN
                        order_items oi ON o.id = oi.order_id
                    INNER JOIN
                        users u ON o.user_id = u.user_id
                    INNER JOIN
                        product p ON oi.product_id = p.id
                    WHERE
                        o.id = ?";
    $statement2 = mysqli_prepare($con, $insertQuery);
    mysqli_stmt_bind_param($statement2, "i", $order_id);
    $insertResult = mysqli_stmt_execute($statement2);

    // Update product quantities in the product table
    $updateProductQuantities = "UPDATE product p
                                INNER JOIN order_items oi ON p.id = oi.product_id
                                SET p.quantity = p.quantity + oi.quantity
                                WHERE oi.order_id = ?";
    $statement3 = mysqli_prepare($con, $updateProductQuantities);
    mysqli_stmt_bind_param($statement3, "i", $order_id);
    $updateProductQuantitiesResult = mysqli_stmt_execute($statement3);

    if($result && $insertResult && $updateProductQuantitiesResult){

        // Delete from the orders table
        $delete_order_query = "DELETE FROM orders WHERE id=?";
        $statement4 = mysqli_prepare($con, $delete_order_query);
        mysqli_stmt_bind_param($statement4, "i", $order_id);
        $delete_order_query_run = mysqli_stmt_execute($statement4);
    
        // Delete from the order_items table
        $delete_items_query = "DELETE FROM order_items WHERE order_id=?";
        $statement5 = mysqli_prepare($con, $delete_items_query);
        mysqli_stmt_bind_param($statement5, "i", $order_id);
        $delete_items_query_run = mysqli_stmt_execute($statement5);

        $_SESSION['message'] = "Order Cancelled!";
        header('Location: ../purchases.php');
        exit;
    
    } else{
        $_SESSION['message'] = "Error: " . mysqli_error($con);
        header('Location: ../purchases.php');
        exit;
    }
}

