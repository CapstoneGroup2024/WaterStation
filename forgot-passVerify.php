<!--------------- INCLUDES --------------->
<?php include('includes/header.php');session_start();?>
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
        <div class="h-100 shadow-sm mx-5" id="wrapper"> <!-- Added shadow-sm class -->
            <!----------Logo Side---------->
            <h1 class="mb-4">Verify Email</h1>  
            <form action="functions/authcode.php" method="POST">
            <input type="hidden" name="user_id" value="<?php echo isset($_GET['user_id']) ? $_GET['user_id'] : ''; ?>">
                <div class="input-box row-md-4 mb-3"> <!-- Added mb-3 class for margin-bottom -->
                    <input type="text" placeholder="Enter Verification Code" name="forgotVerifyCode" required>
                </div>
                <div class="row-md-4 mb-2 btn"> <!-- Added mb-3 class for margin-bottom -->
                    <button type="submit" name="forgotVerifyBtn" class="textBtn" style="margin-bottom: 10px; margin-top: 10px">Submit</button> 
                </div>
                <div class="back row-md-4 mb-2"> <!-- Removed mb-3 class -->
                    <a  href="index.php" class="backTo">Back to Login</a>
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
