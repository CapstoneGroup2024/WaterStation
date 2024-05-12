<?php
include('../config/dbconnect.php');
include('../functions/myAlerts.php');
 

if(isset($_POST['deleteOrderBtn'])){  // CHECK IF THE 'deleteOrderBtn' IS SET IN THE POST REQUEST
    $cart_id = mysqli_real_escape_string($con, $_POST['cart_id']);

    // QUERY TO FETCH CART ITEM DATA
    $cart_query = "SELECT * FROM cart_items WHERE id='$cart_id'";
    $cart_query_run = mysqli_query($con, $cart_query);
    $cart_data = mysqli_fetch_array($cart_query_run);
    $image = $cart_data['image']; // GET THE IMAGE ASSOCIATED WITH THE CART ITEM

    // DELETE THE CART ITEM FROM DATABASE
    $delete_query = "DELETE FROM cart_items WHERE id='$cart_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    // IF DELETION WAS SUCCESSFUL
    if($delete_query_run){
        // CHECK IF THE IMAGE FILE EXISTS AND DELETE IT
        if(file_exists("../uploads/".$image)){
            unlink("../uploads/".$image);
        }
        
        // GET THE LAST AUTO-INCREMENT VALUE
        $last_id_query = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'aquaflowdb' AND TABLE_NAME = 'cart_items'";
        $last_id_result = mysqli_query($con, $last_id_query);
        $last_id_row = mysqli_fetch_assoc($last_id_result);
        $last_auto_increment_value = $last_id_row['AUTO_INCREMENT'];

        // SET THE AUTO-INCREMENT VALUE TO THE LAST DELETED ID
        $alter_query = "ALTER TABLE categories AUTO_INCREMENT = $cart_id";
        mysqli_query($con, $alter_query);
        redirect("../cart.php","CART ITEM DELETED SUCCESSFULLY");
    } else {
        redirect("../cart.php","SOMETHING WENT WRONG");
    }
}
