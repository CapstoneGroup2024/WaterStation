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
    
?>