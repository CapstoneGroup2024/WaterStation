<!--------------- INCLUDES --------------->
<?php include('includes/header.php');?>
<!--------------- CSS --------------->
<link rel="stylesheet" href="assets/css/login.css">    
<!--------------- RESTRICT USER ACCESSING THIS PAGE THROUGH URL  --------------->
<?php 
    if(isset($_SESSION['auth'])){ // CHECKS IF THE USER IS ALREADY LOGGED IN
        $_SESSION['message'] = "You are already logged in";
        header('Location: homepage.php');
        exit();
    }
?>
<div class="row vh-100 g-0">
    <!--------------- LEFT SIDE --------------->
    <div class="col-lg-6 position-relative d-none d-lg-block">
        <div class="bg-holder" style="background-image: url(assets/images/loginPic.png);"></div>
    </div>
    <!--------------- RIGHT SIDE --------------->
    <div class="col-lg-6">
        <?php if(isset($_SESSION['message'])) // THE VARIABLE IS SET, THEN DISPLAY THE MESSAGE
            {
                ?>  <!-- SHOW ALERT --> 
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <?= $_SESSION['message'] ?>.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php 
                unset($_SESSION['message']); // UNSET THE VARIABLE TO ENSURE THAT THE MESSAGE IS ONLY DISPLAYED ONCE
            }
        ?>
        <div class="row align-items-center justify-content-center h-100 g-0 px-4 px-sm-0" id="wrapper">
            <!----------Logo Side---------->
            <h1 style="font-size: 60px" class="title">Forgot Password</h1>
            <form action="functions/authcode.php" method="POST">
                <div class="input-box">
                    <input type="text" placeholder="Email" name="email" required>
                    <i class='bx bxs-user'></i>
                </div>
                <button type="submit" name="logButton" class="btn">Login</button> 
                <div class="register-link">
                    <a href="register.php">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>  
<!--------------- FOOTER --------------->
<?php include('includes/footer.php');?>