<?php
include('../config/dbconnect.php');
include('myAlerts.php');
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if (isset($_POST["reg_button"])) {
    // Registration form submitted
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT);
    $address = $_POST["address"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    
    // Validation
    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($password) || empty($confirm_password)) {
        $_SESSION['message'] = "Please fill in all fields";
        header("Location: ../register.php");
        exit();
    }
    
    if ($password === $confirm_password) {
        $_SESSION['registration_data'] = $_POST;
        $mail = new PHPMailer(true);
    
        try {
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
    
            $con = mysqli_connect("localhost: 3306", "root", "", "aquaflowdb");
            if (!$con) {
                throw new Exception("Database connection failed: " . mysqli_connect_error());
            }
            $sql = "INSERT INTO verification_codes(email, verification_code) VALUES (?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ss", $email, $verification_code);
            $stmt->execute();
    
            // Get the auto-incremented user_id
            $user_id = $stmt->insert_id;
    
            // Redirect to verification page with email and user_id
            header("Location: ../verification.php?email=" . urlencode($email) . "&user_id=" . $user_id);
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }   
    }  else if (isset($_SESSION['registration_data'])) {
        // Registration data exists in session
        $registration_data = $_SESSION['registration_data'];
        $name = $registration_data["name"];
        $email = $registration_data["email"];
        $phone = filter_var($registration_data["phone"], FILTER_SANITIZE_NUMBER_INT);
        $address = $registration_data["address"];
        $password = $registration_data["password"];
        $confirm_password = $registration_data["confirm_password"];
        
        // Verification code logic
        if (!isset($_POST['user_id'])) {
            // User ID is not set, handle the error
            $_SESSION['message'] = "User ID is missing in the form";
            header("Location: ../register.php");
            exit();
        }
    
        // Verification code logic
        if (isset($_POST['verifyBtn'])) {
            // Retrieve verification code and user_id from form
            $code = $_POST['verifyCode'];
            $user_id = $_POST['user_id'];
        
            if (empty($code)) {
                $_SESSION['message'] = "Please fill in all fields";
                header("Location: ../verification.php?email=" . urlencode($email));
                exit();
            }
    
            // Establish database connection
            $con = mysqli_connect("localhost:3306", "root", "", "aquaflowdb");
            if (!$con) {
                // Handle error if connection fails
                $_SESSION['message'] = "Database connection failed: " . mysqli_connect_error();
                header("Location: ../register.php");
                exit();
            }
            
            // Query to retrieve user ID and verification code
            $query = "SELECT verification_code FROM verification_codes WHERE email = ? AND user_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("si", $email, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if (mysqli_num_rows($result) > 0) {
                $row = $result->fetch_assoc();
                $stored_verification_code = $row['verification_code'];
    
                if ($code === $stored_verification_code) {
                    // Insert user data into database
                    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users(name, email, phone, address, password) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $con->prepare($sql);
                    if (!$stmt) {
                        // Handle error if prepare statement fails
                        $_SESSION['message'] = "Prepare statement error: " . $con->error;
                        header("Location: ../register.php");
                        exit();
                    }
    
                    $stmt->bind_param("sssss", $name, $email, $phone, $address, $encrypted_password);
                    $stmt->execute();
                    // Redirect to registration page
                    $_SESSION['message'] = "Registered Successfully";
                    header("Location: ../register.php");
                    exit();
                } else {
                    $_SESSION['message'] = "Incorrect Verification Code! Please try again.";
                    header("Location: ../register.php?email=" . urlencode($email));
                    exit();
                }
            } else {
                $_SESSION['message'] = "No verification code found for the provided user $email and user_id: $user_id";
                header("Location: ../register.php");
                exit();
            }
        }
    }
    
    
else if(isset($_POST['logButton'])) {
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


