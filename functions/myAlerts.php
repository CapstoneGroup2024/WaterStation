<?php
    function redirect($url, $message){ // PASS URL AND MESSAGE PARAMETERS
        $_SESSION['message'] = $message; // MESSAGE
        header('Location: '.$url); // REDIRECT
        exit();
    }

?>