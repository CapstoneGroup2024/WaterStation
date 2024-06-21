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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Store email and user_id in session for verification
    $_SESSION['email'] = $email;
    // Assuming you have a way to get user_id, assign it here
    $user_id = $_SESSION['user_id']; // Make sure user_id is set before this point

    $mail = new PHPMailer(true);

    // Check if email already exists in database
    $email_check_sql = "SELECT * FROM users WHERE email='$email'";
    $email_check_result = mysqli_query($con, $email_check_sql);

    if(mysqli_num_rows($email_check_result) > 0){
        // If email exists, set error message and redirect to editProfile.php
        $_SESSION['message'] = "Email already exists";
        header("Location: ../editProfile.php");
        exit();
    }

    try {
        // Set SMTP options for mailer
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

        // Set mailer debug level
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'aquaflow024@gmail.com';
        $mail->Password = 'pamu swlw fxyj pavq';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set email sender and recipient
        $mail->setFrom('aquaflow024@gmail.com', 'AquaFlow');
        $mail->addAddress($email, $name);
        $mail->isHTML(true);

        // Generate verification code
        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        // Set email subject and body
        $mail->Subject = 'Email verification';
        $mail->Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';
        $mail->send();

        // Insert verification code into database,
        $insert_code_sql = "INSERT INTO verification_codes (email, user_id, verification_code) VALUES (?, ?, ?)";
        $stmt = $con->prepare($insert_code_sql);
        $stmt->bind_param("sis", $email, $user_id, $verification_code);
        $stmt->execute();
        $stmt->close();

        $id = mysqli_insert_id($con);
        $_SESSION['id'] = $id;

        // Redirect to verification page with email and user_id
        header("Location: ../verify_email.php?email=" . urlencode($email));
        exit();

    } catch (Exception $e) {
        // Catch and display mailer error
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

} else if(isset($_POST['codeBtn'])){
    // Handle verification code submission
    $code = $_POST['code'];
    $email = $_SESSION['email'];
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
            $update_email_sql = "UPDATE users SET email='$email' WHERE user_id ='$user_id'";
            $update_email_result = mysqli_query($con, $update_email_sql);

            if($update_email_result){
                $delete_code = "DELETE FROM verification_codes WHERE user_id='$user_id' AND email='$email' AND id='$id'";
                $delete_code_query = mysqli_query($con, $delete_code);

                if($delete_code_query){
                    unset($_SESSION['id']);
                    unset($_SESSION['email']);
                    $_SESSION['message'] = "Email Updated Successfully";
                    header("Location: ../profile.php");
                    exit();
                }
            } else {
                $_SESSION['message'] = "Email Update Failed";
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
