<?php
    include('../config/dbconnect.php');
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
    function getCartItemsByUserId($userId) {
        global $con;
    
        // QUERY TO FETCH CART ITEMS FOR THE SPECIFIED USER 
        $query = "SELECT * FROM cart_items WHERE user_id = '$userId'";
        $result = mysqli_query($con, $query);
    
        if ($result) {
            return $result; // RETURN THE RESULT SET
        } else {
            // HANDLE QUERY ERROR
            echo "Error retrieving cart items: " . mysqli_error($con);
            return false;
        }
    }
    
    function getUserDetails($userId) {
        global $con;
    
        // Check if $con is a valid MySQLi connection
        if (!$con) {
            return null; // Return null if connection is not established
        }
    
        // QUERY TO SELECT USER DETAILS FOR A SPECIFIC USER
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'i', $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        // Check if the query executed successfully
        if (!$result) {
            return null; // Return null if query execution fails
        }
    
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            $userDetails = mysqli_fetch_assoc($result);
            return $userDetails;
        } else {
            // Return null if no user details found
            return null;
        }
    }
    

    function getFirstProductByOrderId($orderId) {
        global $con;
    
        // Prepare and execute the SQL query to fetch the first product based on order ID
        $query = "SELECT * FROM order_items WHERE order_id = ? LIMIT 1";
        $statement = $con->prepare($query);
        $statement->bind_param("i", $orderId);
        $statement->execute();
        $result = $statement->get_result();
    
        // Fetch the first product and return its details
        if ($row = $result->fetch_assoc()) {
            // Assuming you have a products table where you can retrieve product details based on product ID
            $product_id = $row['product_id'];
            $product_query = "SELECT * FROM product WHERE id = ? LIMIT 1";
            $product_statement = $con->prepare($product_query);
            $product_statement->bind_param("i", $product_id);
            $product_statement->execute();
            $product_result = $product_statement->get_result();
            $product = $product_result->fetch_assoc();
    
            // Return the product details
            return array(
                'product_name' => $product['name']
            );
        } else {
            // If no product found, return null
            return null;
        }
    }

    function getOrderData($table, $timestamp_column = 'order_at') {
        global $con;
        $query = "SELECT * FROM $table ORDER BY $timestamp_column DESC"; // SQL query to select all data from the table and order by timestamp_column in descending order
        return $query_run = mysqli_query($con, $query); // Execute query and return result
    }

    function getProductTransac($orderId) {
        global $con;
    
        // Prepare and execute the SQL query to fetch the first product based on order ID
        $query = "SELECT * FROM order_transac WHERE order_id = ? LIMIT 1";
        $statement = $con->prepare($query);
        $statement->bind_param("i", $orderId);
        $statement->execute();
        $result = $statement->get_result();
    
        // Fetch the first product and return its details
        if ($row = $result->fetch_assoc()) {
            // Assuming you have a products table where you can retrieve product details based on product ID
            $product_id = $row['product_id'];
            $product_query = "SELECT * FROM product WHERE id = ? LIMIT 1";
            $product_statement = $con->prepare($product_query);
            $product_statement->bind_param("i", $product_id);
            $product_statement->execute();
            $product_result = $product_statement->get_result();
            $product = $product_result->fetch_assoc();
    
            // Return the product details
            return array(
                'product_name' => $product['name']
            );
        } else {
            // If no product found, return null
            return null;
        }
    }
    
?>