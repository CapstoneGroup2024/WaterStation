<?php
session_start();
include('../config/dbconnect.php');
include('../functions/myAlerts.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// REQUIRE AUTOMATIC LOADER FOR PHPMAILER AND SET ERROR REPORTING
require '../vendor/autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['profileUpdateBtn'])){
    // Assign values from POST data
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $update_profile_sql = "UPDATE users SET name=?, phone=?, address=? WHERE user_id=?";
    $stmt = $con->prepare($update_profile_sql);
    $stmt->bind_param("sssi", $name, $phone, $address, $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Profile Updated Successfully";
            header("Location: ../profile.php");
            exit();
        } else {
            // Update failed
            $_SESSION['message'] = "Profile Update Failed";
            header("Location: ../profile.php");
            exit();
        }
} else if(isset($_POST['codeBtn'])){
    // Handle verification code submission
    $code = $_POST['code'];
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
    $address = $_SESSION['address'];
    $phone = $_SESSION['phone'];
    $user_id = $_SESSION['user_id'];
    $id = $_SESSION['id'];

    // Retrieve verification code from database
    $code_query = "SELECT verification_code FROM verification_codes WHERE email='$email' AND user_id='$user_id' AND id='$id'";
    $code_query_result = mysqli_query($con, $code_query);

    if($code_query_result){
        $row = mysqli_fetch_assoc($code_query_result);
        $stored_code = $row['verification_code'];

        if($code === $stored_code){
            // Verification code matches, update email in database
            $update_email_sql = "UPDATE users SET email='$email', name='$name', address='$address', phone='$phone' WHERE user_id ='$user_id'";
            $update_email_result = mysqli_query($con, $update_email_sql);

            if($update_email_result){
                $delete_code = "DELETE FROM verification_codes WHERE user_id='$user_id' AND email='$email' AND id='$id'";
                $delete_code_query = mysqli_query($con, $delete_code);

                if($delete_code_query){
                    unset($_SESSION['id']);
                    unset($_SESSION['email']);
                    unset($_SESSION['name']);
                    unset($_SESSION['address']);
                    unset($_SESSION['phone']);
                    $_SESSION['message'] = "Profile Updated Successfully";
                    header("Location: ../profile.php");
                    exit();
                }
            } else {
                $_SESSION['message'] = "Profile Update Failed";
                header("Location: ../editProfile.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "Verification Code does not match . $stored_code";
            header("Location: ../verify_email.php?email=" . urlencode($email) . "&user_id=" . $user_id);
            exit();
        }
    } else {
        $_SESSION['message'] = "Error retrieving verification code";
        header("Location: ../editProfile.php");
        exit();
    }
}
?>
