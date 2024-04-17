<?php
include('../functions/myAlerts.php');

    if(isset($_SESSION['auth'])){ //CHECKS IF USER IS LOGGED IN
        if($_SESSION['role'] != 1){ //CHECK IF USER IS NOT ADMIN
            redirect("../homepage.php", "You are not authorized to access this page");
        }
    } else {
        redirect("../index.php", "Login to continue");
    }
?>
