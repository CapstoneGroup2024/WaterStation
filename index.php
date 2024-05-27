<!--------------- INCLUDES --------------->
<?php 
    session_start();
    include('includes/header.php');
?>
<!--------------- CSS --------------->
<link rel="stylesheet" href="assets/css/login.css">    

<!--------------- RESTRICT USER ACCESSING THIS PAGE THROUGH URL  --------------->
<div class="row vh-100 g-0">
    <!--------------- LEFT SIDE --------------->
    <div class="col-lg-6 position-relative d-none d-lg-block">
        <div class="bg-holder" style="background-image: url(assets/images/loginPic.png);"></div>
    </div>
    <!--------------- RIGHT SIDE --------------->
    <div class="col-lg-6">
        <div class="row align-items-center justify-content-center h-100 g-0 px-4 px-sm-0" id="wrapper">
            <!----------Logo Side---------->
            <h1 style="font-size: 60px" class="title">Login</h1>
            <form action="functions/authcode.php" method="POST">
                <div class="input-box">
                    <input type="text" placeholder="Email" name="email" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Password" name="password" required>
                    <i class='bx bxs-lock-alt' ></i>
                </div>
                <div class="remember-forgot">
                    <label><input class="remember" name="remember_me" type="checkbox">Remember me</label>
                    <a href="forgot-password.php">Forgot password?</a>
                </div>
                <div class="line"></div>
                <div class="register-link">
                    <p class="text" id="contactNUm">Login using <a href="Register.html" >Contact Number</a></p>
                </div>
                <button type="submit" name="logButton" class="btn">Login</button> 
                <div class="register-link">
                    <p class="text">Don't have an account? <a href="register.php">Register</a></p>
                </div>
            </form>
        </div>
    </div>
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