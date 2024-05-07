<?php
    session_start(); // START SESSION

    if(isset($_SESSION['auth'])){ // IF LOGGED IN
        unset($_SESSION['auth']); // UNSET ADMIN
        unset($_SESSION['auth_user']); // UNSET USER
        $_SESSION['message'] = "Logged Out Successfully"; 
    }
    header('Location: index.php'); // REDIRECT TO LOGIN
?>