<?php
session_start();
include('../config/dbconnect.php');
include('../functions/myAlerts.php');

if(isset($_POST['profileUpdateBtn'])){
    // Assign values from POST data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Store data in session for confirmation
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;
    $_SESSION['address'] = $address;

    $_SESSION['confirm_message'] = "Confirm to Update Details?";
    header('Location: ../editProfile.php');
    exit; // Make sure to exit to avoid further execution
}

if(isset($_POST['confirmUpdate'])) {
    // Retrieve data from session
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone'];
    $address = $_SESSION['address'];

    // Example: Assume $user_id is defined somewhere in your code
    $user_id = $_SESSION['user_id'];

    // Update query
    $update_query = "UPDATE users SET name='$name', email='$email', phone='$phone', address='$address' WHERE user_id = '$user_id'";
    $update_query_run = mysqli_query($con, $update_query);

    if($update_query_run){
        // Clear session variables
        unset($_SESSION['name']);
        unset($_SESSION['email']);
        unset($_SESSION['phone']);
        unset($_SESSION['address']);

        // Optionally set a success message or perform other actions
        $_SESSION['message'] = "Profile updated successfully.";
        $_SESSION['success'] = true;
        header('Location: ../editProfile.php');
        exit; // Make sure to exit after redirection
    } else {
        $_SESSION['success_message'] = "Profile Update failed.";

        header('Location: ../editProfile.php');
        exit; // Make sure to exit after redirection
    }
}

?>
