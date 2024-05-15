<?php
include('../config/dbconnect.php');
include('myAlerts.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

if(isset($_POST['reg_button'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT);
    $address = $_POST["address"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validation
    if(empty($name) || empty($email) || empty($phone) || empty($address) || empty($password) || empty($confirm_password)) {
        redirect("../register.php", "Please fill in all fields");
    }

    if($password != $confirm_password) {
        redirect("../register.php", "Password do not match");
    }

    // Check if email already exists
    $check_email_query = "SELECT email FROM users WHERE email=?";
    $stmt = mysqli_prepare($con, $check_email_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if(mysqli_stmt_num_rows($stmt) > 0) {
        redirect("../register.php", "Email already registered");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate verification code
    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

    // Send verification email
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 2;
    try {
        // Configure PHPMailer
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'denisesaronaa@gmail.com'; // Your Gmail address
        $mail->Password = 'zkjj fufn yrjx ycur'; // Your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 465;
        $mail->setFrom('denisesaronaa@gmail.com', 'Aqua Flow');
        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = 'Email verification';
        $mail->Body = '<p>Your verification code is: <b style="font-size: 30px; ">' . $verification_code . '</b></p>';

        $mail->send();

        // Insert user into database
        $insert_query = "INSERT INTO users (name, email, phone, address, password, verification_code, email_verified_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt, "sssssss", $name, $email, $phone, $address, $hashed_password, $verification_code, NULL);
        if(mysqli_stmt_execute($stmt)) {
            redirect("../homepage.php", "Registered Successfully");
        } else {
            redirect("../register.php", "Something went wrong");
        }
    } catch (Exception $e) {
        $error_message = "Error sending verification email: " . $mail->ErrorInfo;
        redirect("../register.php", $error_message);
    }
} elseif(isset($_POST['logButton'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email exists
    $login_query = "SELECT * FROM users WHERE email=?";
    $stmt = mysqli_prepare($con, $login_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1) {
        $userdata = mysqli_fetch_assoc($result);
        $stored_password = $userdata['password'];

        // Verify password
        if(password_verify($password, $stored_password)) {
            $_SESSION['auth'] = true;
            $_SESSION['user_id'] = $userdata['user_id'];
            $_SESSION['auth_user'] = [
                'name' => $userdata['name'],
                'email' => $userdata['email']
            ];

            $role = $userdata['role'];
            $_SESSION['role'] = $role;

            if($role == 1) {
                $_SESSION['message'] = "Welcome to Admin Dashboard";
                header('Location: ../admin/index.php');
            } else {
                $_SESSION['message'] = "Logged in Successfully";
                header('Location: ../homepage.php');
            }
        } else {
            $_SESSION['message'] = "Invalid Credentials";
            header('Location: ../index.php');
        }
    } else {
        $_SESSION['message'] = "Invalid Credentials";
        header('Location: ../index.php');
    }
}
?>
