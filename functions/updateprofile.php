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
} else if(isset($_POST['emailUpdateBtn'])){
    // Handle verification code submission
    $email = $_POST['email'];
    $user_id = $_SESSION['user_id'];

    $email_check_sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $con->prepare($email_check_sql);
    $stmt->bind_param("s", $email); // BIND EMAIL PARAMETER
    $stmt->execute(); // EXECUTE THE QUERY
    $email_check_sql_run = $stmt->get_result(); // GET THE RESULT

    // CHECK IF EMAIL EXISTS IN DATABASE
    if ($email_check_sql_run->num_rows > 0) {
        // EMAIL NOT REGISTERED, REDIRECT TO REGISTRATION PAGE WITH MESSAGE
        $_SESSION['message'] = "Email already regisstered!";
        header('Location: ../emailpage.php');
        exit();
    }

    // INITIALIZE PHPMailer
    $mail = new PHPMailer(true);
    
    try {
        // CONFIGURE SMTP OPTIONS FOR SECURE CONNECTION
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];
        
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; // ENABLE DEBUG OUTPUT
        $mail->isSMTP(); // SET MAILER TO USE SMTP
        $mail->Host = 'smtp.gmail.com'; // SPECIFY SMTP SERVER
        $mail->SMTPAuth = true; // ENABLE SMTP AUTHENTICATION
        $mail->Username = 'aquaflow024@gmail.com'; // SMTP USERNAME
        $mail->Password = 'pamu swlw fxyj pavq'; // SMTP PASSWORD
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ENABLE TLS ENCRYPTION
        $mail->Port = 587; // TCP PORT TO CONNECT TO

        // SET EMAIL SENDER AND RECIPIENT
        $mail->setFrom('aquaflow024@gmail.com', 'AquaFlow');
        $mail->addAddress($email, 'AquaFlow'); // ADD RECIPIENT EMAIL
        $mail->isHTML(true); // SET EMAIL FORMAT TO HTML

        // GENERATE A VERIFICATION CODE
        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        // SET EMAIL SUBJECT AND BODY CONTENT
        $mail->Subject = 'Email verification';
        $mail->Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';
        $mail->send(); // SEND THE EMAIL

        // INSERT VERIFICATION CODE INTO DATABASE
        $sql = "INSERT INTO verification_codes (email, verification_code, user_id) VALUES (?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssi", $email, $verification_code, $user_id); // BIND PARAMETERS
        $stmt->execute(); // EXECUTE THE QUERY

        $id = mysqli_insert_id($con);

        // Store user_id in session for future use
        $_SESSION['id'] = $id;
        $_SESSION['email'] = $email;
        // CHECK IF STATEMENT EXECUTED SUCCESSFULLY
        if ($stmt) {
            // REDIRECT TO VERIFICATION PAGE WITH SUCCESS MESSAGE
            $_SESSION['message'] = "Verification Code Sent to Email";
            header("Location: ../verify_email.php?email=" . urlencode($email) );
            exit();
        } else {
            // REDIRECT TO INDEX PAGE WITH ERROR MESSAGE
            $_SESSION['message'] = "Error";
            header('Location: ../emailpage.php');
            exit();
        }
    } catch (Exception $e) {
        // HANDLE MAIL SENDING ERROR
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    } finally {
        $con->close(); // CLOSE THE DATABASE CONNECTION
    }
} else if(isset($_POST['codeBtn'])){
    $code = $_POST['code'];
    $user_id = $_SESSION['user_id'];
    $id = $_SESSION['id'];
    $email = $_SESSION['email'];
     // Retrieve verification code from database
    $code_query = "SELECT verification_code FROM verification_codes WHERE email='$email' AND user_id='$user_id' AND id='$id'";
    $code_query_result = mysqli_query($con, $code_query);
 
     if($code_query_result){
         $row = mysqli_fetch_assoc($code_query_result);
         $stored_code = $row['verification_code'];
 
         if($code === $stored_code){
             // Verification code matches, update email in database
             $update_email_sql = "UPDATE users SET email='$email' WHERE user_id ='$user_id'";
             $update_email_result = mysqli_query($con, $update_email_sql);
 
             if($update_email_result){
                 $delete_code = "DELETE FROM verification_codes WHERE user_id='$user_id' AND email='$email' AND id='$id'";
                 $delete_code_query = mysqli_query($con, $delete_code);
 
                 if($delete_code_query){
                     unset($_SESSION['id']);
                     unset($_SESSION['email']);
                     $_SESSION['message'] = "Email Updated Successfully";
                     header("Location: ../manageAccount.php");
                     exit();
                 }
             } else {
                 $_SESSION['message'] = "Email Update Failed";
                 header("Location: ../manageAccount.php");
                 exit();
             }
         } else {
             $_SESSION['message'] = "Verification Code does not match . $stored_code . $code . $id . $user_id";
             header("Location: ../verify_email.php?email=" . urlencode($email) . "&user_id=" . $user_id);
             exit();
         }
     } else {
         $_SESSION['message'] = "Error retrieving verification code";
         header("Location: ../emailpage.php");
         exit();
     }
}
?>
