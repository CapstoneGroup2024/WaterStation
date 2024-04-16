<?php
    if(isset($_SESSION['auth'])){ // CHECK IF A USER LOGGED IN
        if($_SESSION['role'] != 1){
            $_SESSION['message'] = "You are not authorized to access this page";
            header('Location: ../index.php');
        }
    } else{ // IF ADMIN LOGGED IN
        $_SESSION['message'] = "Login to continue";
        header('Location: ../index.php');
    }
?>