<?php
include('config/dbconnect.php');
function getAllActive($table){ 
    global $con; 
    $query = "SELECT * FROM $table WHERE status='1' "; 
    return $query_run = mysqli_query($con, $query); 
}

function getCartItemsByUserId($userId) {
    global $con; 

    $query = "SELECT * FROM cart_items WHERE user_id = '$userId'";
    
    $result = mysqli_query($con, $query);

    if ($result) {
        return $result; 
    } else {
        echo "Error retrieving cart items: " . mysqli_error($con);
        return false;
    }
}

function getUserDetails($userId) {
    global $con; 

    $query = "SELECT * FROM users WHERE user_id = '$userId'";
    
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $userDetails = mysqli_fetch_assoc($result);
        return $userDetails; 
    } else {
        echo "Error retrieving user details: " . mysqli_error($con);
        return false;
    }
}

function getByID($table, $id){ 
    global $con; 
    $query = "SELECT * FROM $table WHERE id='$id'"; 
    $result = mysqli_query($con, $query); 
    if ($result) {
        if(mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            echo "No records found for ID: $id";
            return false;
        }
    } else {
        echo "Error executing query: " . mysqli_error($con);
        return false;
    }
}

function getOrderItemsByUserId($userId) {
    global $con; 

    $query = "SELECT * FROM orders WHERE user_id = '$userId'";
    
    $result = mysqli_query($con, $query);

    if ($result) {
        return $result; 
    } else {
        echo "Error retrieving cart items: " . mysqli_error($con);
        return false;
    }
}
