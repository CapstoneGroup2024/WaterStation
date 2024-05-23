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
