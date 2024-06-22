<?php 
    include('includes/header.php');
    include('includes/navbar.php');
    include('functions/userFunctions.php'); 
?>
<link rel="stylesheet" href="assets/css/details.css">   
<section class="p-5 text-sm-start mt-4">
    <div class="Register mt-4">
        <div class="heading mt-4">Change Password</div>
        <div class="profile-card text-dark">
            <form class="regform" action="functions/updateprofile.php" method="POST">
                <div class="col mt-1">
                <div class="input-wrapper ">
                            <span class="p-2">New Password: </span><input type="password" placeholder="Enter new password" name="password">
                        </div>
                    <div class="row">
                        <div class="input-wrapper ">
                            <span class="p-2">Confirm Password: </span><input type="password" placeholder="Confirm new password" name="confirm_password">
                        </div>
                        <li>
                            <button type="submit" id="submitbtn" name="passwordUpdateBtn" class="button-text mt-4">Submit</button>
                        </li>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section>
    <?php
    echo $_SESSION['user_id'];
    ?>
</section>
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