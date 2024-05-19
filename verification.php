<!--------------- INCLUDES --------------->
<?php include('includes/header.php');?>
<!--------------- CSS --------------->
<link rel="stylesheet" href="assets/css/forgotP.css">    
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
    <div class="col-lg-6 card-body shadow-sm"> <!-- Added shadow-sm class -->
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
        <div class="h-100 shadow-sm mx-5" id="wrapper"> <!-- Added shadow-sm class -->
            <!----------Logo Side---------->
            <h1 class="mb-4">Verify Email</h1>  
            <form action="functions/authcode.php" method="POST">
                <div class="input-box row-md-4 mb-3"> <!-- Added mb-3 class for margin-bottom -->
                    <input type="text" placeholder="Enter Verification Code" name="verifyCode" required>
                    <i class='bx bxs-lock'></i>
                </div>
                <div class="row-md-4 mb-2 btn"> <!-- Added mb-3 class for margin-bottom -->
                    <button type="submit" name="logButton" class="textBtn" style="margin-bottom: 10px; margin-top: 10px">Submit</button> 
                </div>
                <div class="back row-md-4 mb-2"> <!-- Removed mb-3 class -->
                    <a href="register.php" class="backTo">Back to Register</a>
                </div>
            </form>
        </div>
    </div>
</div>  
<!--------------- FOOTER --------------->
<?php include('includes/footer.php');?>
