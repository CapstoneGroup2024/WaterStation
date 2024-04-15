<!--------------- HEADER --------------->
<?php include('includes/header.php');?>
<link rel="stylesheet" href="assets/css/login.css">    
<?php session_start(); ?> <!-- Start Session -->
<!--------------- LOGIN FORM --------------->
<div class="wrapper"> 
    <?php if(isset($_SESSION['message'])) // THE VARIABLE IS SET, THEN DISPLAY THE MESSAGE
    {
        ?>  <!-- SHOW ALERT --> 
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Hey!</strong> <?= $_SESSION['message'] ?>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php 
        unset($_SESSION['message']); // UNSET THE VARIABLE TO ENSURE THAT THE MESSAGE IS ONLY DISPLAYED ONCE
    }
    ?>
    <h1>Login</h1>
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
        <label><input type="checkbox">Remember me</label>
        <a href="#">Forgot password?</a>
    </div>
    <div class="position-relative">     
        <hr class="text-secondary">
            <div class="divider-content-center">or</div>
    </div>
    <div class="register-link">
        <p>Login using <a href="Register.html">Contact Number</a></p>
    </div><br>
    
    
    <button type="submit" name="logButton" class="btn">Login</button>
                
    <div class="register-link">
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
    </form>
</div>
 <!--------------- FOOTER --------------->
<?php include('includes/footer.php');?>