<?php
session_start(); // SESSION START

    if(isset($_SESSION['auth'])){ //CHECKS IF USER IS LOGGED IN
        if($_SESSION['role'] != 1){ //CHECK IF USER IS NOT ADMIN
            $_SESSION['message'] = "You are not authorized to access this page";
            header('Location: ../index.php');
            exit(); 
        }
    } else {
        $_SESSION['message'] = "Login to continue"; // REDIRECT USER TO LOGIN   
        header('Location: ../index.php');
        exit(); 
    }
?>
