<?php 
    include('includes/header.php');
    include('includes/navbar.php');
    include('functions/userFunctions.php'); 
?>
<link rel="stylesheet" href="assets/css/profile.css">   
<section class="p-5 p-md-5 text-sm-start mt-4">
    <div class="Register mt-4 p-5">
        <div class="heading">Email Verification</div>
            <form class="regform" action="functions/updateprofile.php" method="POST">
                <ul>
                    <li>
                        <p>We've sent you a verification code through your email.</p>
                    </li>
                    <li>
                        <label for="">Verification Code:</label>
                        <div class="input-wrapper">
                            <input type="text" name="code">
                        </div>
                    </li>
                    <?php
                        echo $_SESSION['user_id'];
                        ?>
                    <li>
                    <input type="hidden" name="user_id" value="<?php echo isset($_GET['user_id']) ? $_GET['user_id'] : ''; ?>">
                        <button type="submit" id="submitbtn" name="codeBtn" class="button-text">Submit</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</section>


<section>
    <?php
    echo $_SESSION['user_id'];
    ?>
</section>
<!--------------- ALERTIFY JS --------------->
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