<?php
    // INCLUDES 
    include('includes/header.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

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
            }   
        } else{
            $_SESSION['message'] = "Password do not match";
        }
    }
    
?>


<!--------------- INCLUDES --------------->

<link rel="stylesheet" href="assets/css/register.css">
<?php // RESTRICT USER ACCESSING THIS PAGE THROUGH URL
    if(isset($_SESSION['auth'])){
        $_SESSION['message'] = "You are already logged in";
        header('Location: homepage.php');
        exit();
    }
?> 
<!--------------- REGISTER FORM --------------->
<div class="Register mt-5" >
    <h1 class="heading">Register Here!</h1>
    <form method="POST">
        <!--------------- FIRST ROW --------------->
        <div class="regform">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="firstn" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" id="firstn" placeholder="Enter your full name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="Con" class="form-label">Contact No.</label>
                        <input type="number" name="phone" class="form-control" id="Con" placeholder="Enter your number">
                    </div>
                </div>
            </div>
            <!--------------- SECOND ROW --------------->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="add" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="add" placeholder="Enter your address">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="em" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" id="em" placeholder="Enter your email">
                    </div>
                </div>
            </div>
            <!---------------THIRD ROW --------------->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="pw" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="pw" placeholder="Enter your password">
                        <p id="message"><span id="strenght"></span></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="type" class="form-label">Re-Type Password</label>
                        <input type="password" name="confirm_password" class="form-control" id="type" placeholder="Confirm password">
                    </div>
                </div>
            </div>
            <!--------------- SUBMIT BUTTON --------------->
            <div class="btn-container">
                <button type="submit" name="reg_button" class="button-text">Submit</button>
            </div>
            <!--------------- TO LOGIN PAGE --------------->
            <div class="row">
                <div class="col">
                    <div class="register-link">
                        <p id="loginlink">Already have an account? <a href="index.php" id="link">Log in Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!--------------- ALERTIFY JS --------------->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
    <?php
        if(isset($_SESSION['message'])){ // CHECK IF SESSION MESSAGE VARIABLE IS SET
    ?>
    alertify.alert('AquaFlow', '<?= $_SESSION['message']?>').set('modal', true).set('movable', false); // DISPLAY MESSAGE MODAL
    <?php
        unset($_SESSION['message']); // UNSET THE SESSION MESSAGE VARIABLE
        }
    ?>
</script>
 <!--------------- FOOTER --------------->
<?php include('includes/footer.php');?>