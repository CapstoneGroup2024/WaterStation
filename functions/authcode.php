<?php
include('../config/dbconnect.php');
include('myAlerts.php');
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if(isset($_POST["reg_button"])){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT);
    $address = $_POST["address"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    // Validation
    if(empty($name) || empty($email) || empty($phone) || empty($address) || empty($password) || empty($confirm_password)) {
        $_SESSION['message'] = "Please fill in all fields";
        header("Location: ../register.php");
        exit();
    }
    
    if($password === $confirm_password) {
        $mail = new PHPMailer(true);

        try{
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];
            
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail -> isSMTP();
            $mail -> Host = 'smtp.gmail.com';
            $mail -> SMTPAuth = true;
            $mail -> Username = 'aquaflow024@gmail.com';
            $mail -> Password = 'pamu swlw fxyj pavq';
            $mail -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail -> Port = 587;

            $mail -> setFrom('aquaflow024@gmail.com', 'AquaFlow');
            $mail -> addAddress($email, $name);
            $mail -> isHTML(true);

            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

            $mail -> Subject = 'Email verification';
            $mail -> Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';
            $mail -> send();

            $encrypted_password = password_hash($password, PASSWORD_DEFAULT);

            
                $con = mysqli_connect("localhost: 3306", "root", "", "aquaflowdb");
                if (!$con) {
                    throw new Exception("Database connection failed: " . mysqli_connect_error());
                }
                $sql = "INSERT INTO users(name, email, phone, address, password, verification_code, email_verified_at) VALUES ('" . $name . "', '" . $email . "', '" . $phone . "', '" . $address . "', '" . $encrypted_password . "', '" . $verification_code . "', NULL)";

                mysqli_query($con, $sql);
                header("Location: verification.php?email=" . $email);
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
    } else{
        $_SESSION['message'] = "Password do not match";
        header("Location: ../register.php");
        exit();
    }
} else if(isset($_POST['logButton'])) {
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
            $_SESSION['message'] = "Incorrect Password";
            header("Location: ../index.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Invalid Credentials";
        header('Location: ../index.php');
        exit();
    }
}
?>
