<?php
    include('config/dbconnect.php');

    // FUNCTION TO GET ALL ACTIVE RECORDS FROM A SPECIFIED TABLE
    function getAllActive($table){ 
        global $con; 
        $query = "SELECT * FROM $table WHERE status='1' "; 
        return $query_run = mysqli_query($con, $query); 
    }

    // FUNCTION TO GET CART ITEMS BY USER ID
    function getCartItemsByUserId($userId) {
        global $con; 

        // QUERY TO SELECT CART ITEMS FOR A SPECIFIC USER
        $query = "SELECT * FROM cart_items WHERE user_id = '$userId'";
        $result = mysqli_query($con, $query);

        if ($result) {
            return $result; 
        } else {
            // DISPLAY ERROR MESSAGE IF QUERY FAILED
            echo "Error retrieving cart items: " . mysqli_error($con);
            return false;
        }
    }

    // FUNCTION TO GET USER DETAILS BY USER ID
    function getUserDetails($userId) {
        global $con; 

        // QUERY TO SELECT USER DETAILS FOR A SPECIFIC USER
        $query = "SELECT * FROM users WHERE user_id = '$userId'";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $userDetails = mysqli_fetch_assoc($result);
            return $userDetails; 
        } else {
            // DISPLAY ERROR MESSAGE IF QUERY FAILED
            echo "Error retrieving user details: " . mysqli_error($con);
            return false;
        }
    }

    // FUNCTION TO GET RECORD BY ID FROM A SPECIFIED TABLE
    function getByID($table, $id){ 
        global $con; 
        $query = "SELECT * FROM $table WHERE id='$id'"; 
        $result = mysqli_query($con, $query); 

        if ($result) {
            // CHECK IF THERE ARE RESULTS
            if(mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            } else {
                // DISPLAY MESSAGE IF NO RECORDS FOUND
                echo "No records found for ID: $id";
                return false;
            }
        } else {
            // DISPLAY ERROR MESSAGE IF QUERY FAILED
            echo "Error executing query: " . mysqli_error($con);
            return false;
        }
    }

    // FUNCTION TO GET ORDER ITEMS BY USER ID
    function getOrderItemsByUserId($userId) {
        global $con; 

        // QUERY TO SELECT ORDER ITEMS FOR A SPECIFIC USER
        $query = "SELECT * FROM orders WHERE user_id = '$userId'";
        $result = mysqli_query($con, $query);

        if ($result) {
            return $result; 
        } else {
            // DISPLAY ERROR MESSAGE IF QUERY FAILED
            echo "Error retrieving cart items: " . mysqli_error($con);
            return false;
        }
    }

    function getActiveCartItemsByUserId($userId, $con) {
        $query = "SELECT ci.*, p.id AS product_id, p.name AS product_name, c.id AS category_id, c.name AS category_name 
                  FROM cart_items ci
                  LEFT JOIN product p ON ci.id = p.id
                  LEFT JOIN categories c ON p.id = c.id
                  WHERE ci.user_id = ?";
        $statement = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($statement, "s", $userId);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        if ($result) {
            return $result; 
        } else {
            error_log("Error retrieving cart items: " . mysqli_error($con));
            return false;
        }
    }
    
    function isProductActive($productId, $categoryId, $con) {
        $product_query = "SELECT * FROM product WHERE id = ? LIMIT 1";
        $category_query = "SELECT * FROM categories WHERE id = ? LIMIT 1";
        
        $stmt_product = mysqli_prepare($con, $product_query);
        $stmt_category = mysqli_prepare($con, $category_query);
        
        mysqli_stmt_bind_param($stmt_product, "i", $productId);
        mysqli_stmt_bind_param($stmt_category, "i", $categoryId);
        
        mysqli_stmt_execute($stmt_product);
        $product_result = mysqli_stmt_get_result($stmt_product);
        $productIsActive = mysqli_num_rows($product_result) > 0;
        
        mysqli_stmt_execute($stmt_category);
        $category_result = mysqli_stmt_get_result($stmt_category);
        $categoryIsActive = mysqli_num_rows($category_result) > 0;
        
        mysqli_stmt_close($stmt_product);
        mysqli_stmt_close($stmt_category);
        
        return $productIsActive && $categoryIsActive;
    }