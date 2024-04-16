<?php

// START SESSIONN
session_start();
include('../config/dbconnect.php');
            
if(isset($_POST['reg_button'])){ // IF FORM SUBMIT IS FROM reg_button
    // GET USER DATA
    $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST["name"]));
    $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST["email"]));
    $phone = filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT);
    $address = htmlspecialchars(mysqli_real_escape_string($con, $_POST["address"]));
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // CHECK IF DATA INPUTTED IS EMPTY
    if(empty($name) || empty($email) || empty($phone) || empty($address) || empty($password) || empty($confirm_password)) {
        $_SESSION['message'] = "Please fill in all fields";
        header("Location: ../register.php");
        exit();
    }
    
    // CHECK IF EMAIL IS ALREADY REGISTERED ON THE DATABASE
    $check_email_query = "SELECT email FROM users WHERE email='$email'";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    // IF A ROW WAS RETURNED BY THE SQL QUERY WHICH IS GREATER THAN ZERO, EMAIL ALREADY EXIST
    if(mysqli_num_rows($check_email_query_run) > 0){
        $_SESSION['message'] = "Email already registered";
        header("Location: ../register.php");
    } else { // CHECK IF PASSWORD IS THE SAME WITH CONFIRM PASSWORD
        if($password == $confirm_password){
            // HASH THE PASSWORD
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // PREPARED STATEMENT FOR SECURITY
            $insert_query = "INSERT INTO users (name, email, phone, address, password) VALUES (?, ?, ?, ?, ?)";

            // PLACEHOLDER FOR THE PREPARED STATEMENT
            $stmt = mysqli_prepare($con, $insert_query); 
            mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $address, $hashed_password); // FIVE (s) FOR FIVE STRINGS

            // CHECK IF REGISTRATION IS SUCCESSFUL
            if(mysqli_stmt_execute($stmt)){
                $_SESSION['message'] = "Registered Successfully";
                header("Location: ../homepage.php");
                exit();
            } else {
                $_SESSION['message'] = "Something went wrong";
                header("Location: ../register.php");
                exit();
            }
        } else { // IF PASSWORD DONT MATCH
            $_SESSION['message'] = "Passwords do not match";
            header("Location: ../register.php");
            exit();
        }
    }
}else if(isset($_POST['logButton'])){ // IF FORM SUBMIT IS FROM logButton
    // GET USER DATA EMAIL AND PASSWORD
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // HASHED THE PASSWORD TO MATCH WITH THE ONE IN THE DATABASE
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $login_query = "SELECT * FROM users WHERE email='$email'"; // SELECT EMAIL FROM USER TABLE
    $login_query_run = mysqli_query($con, $login_query); // QUERYING THE DATABASE

    // IF A ROW WAS RETURNED BY THE SQL QUERY WHICH IS GREATER THAN ZERO, EMAIL ALREADY EXIST
    if(mysqli_num_rows($login_query_run) > 0){ //
        $userdata = mysqli_fetch_array($login_query_run); // RETURNS AN ARRAY THAT CORRESPONDS TO THE FETCHED ROW
        $stored_password = $userdata['password']; // HOLDS THE HASHED PASSWORRRD

        // VERIFY THE HASHED PASSWORD
        if(password_verify($password, $stored_password)){
            $_SESSION['auth'] = true;

            $username = $userdata['name'];
            $useremail = $userdata['email'];
            $role = $userdata['role'];

            $_SESSION['auth_user'] = [
                'name' => $username,
                'email' => $useremail
            ];

            $_SESSION['role'] = $role;

            if($role == 1){ // CHECK IF ADMIN WHICH EQUAL TO 1 IN ROLE COLUMN
                $_SESSION['message'] = "Welcome to Admin Dashboard";
                header('Location: ../admin/index.php');
            } else {
                // IF USER LOGIN SUCCESSFUL
                $_SESSION['message'] = "Logged in Successfully";
                header('Location: ../homepage.php');
                exit();
            }
        } else {
            $_SESSION['message'] = "Invalid Credentials";
            header('Location: ../index.php');
            exit();
        }
    } else {
        $_SESSION['message'] = "Invalid Credentials";
        header('Location: ../index.php');
        exit();
    }
}

