<?php
    include('config/dbconnect.php');
    function getAllActive($table){ // FUNCTION TO RETRIEVE ALL ACTIVE RECORD FROM SPECIFIC TABLE
        global $con; // Access the global database connection object
        $query = "SELECT * FROM $table WHERE status='1' "; // SQL query to select all records with status '0'
        return $query_run = mysqli_query($con, $query); // Execute the query and return the result
    }


    // Function to redirect to a specified URL with a message
    function redirect($url, $message){ // Accepts URL and message parameters
        $_SESSION['message'] = $message; // Store the message in the session variable
        header('Location: '.$url); // Redirect the user to the specified URL
        exit(); // Exit the script to prevent further execution
    }


    ?>