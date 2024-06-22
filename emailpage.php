<?php 
    include('includes/header.php');
    include('includes/navbar.php');
    include('functions/userFunctions.php'); 

    // Assuming $con is your database connection
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id='$user_id'";
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0){
            $data = mysqli_fetch_assoc($result); // Fetch user data
        }
    }
?>
<link rel="stylesheet" href="assets/css/details.css">   
<section class="p-5 text-sm-start mt-4">
    <div class="Register mt-4">
        <div class="heading mt-4">Change Email</div>
        <div class="profile-card">
            <form class="regform" action="functions/updateprofile.php" method="POST">
                <div class="text-dark">
                <div class="col mt-1">
                        <div class="row">
                        <div class="input-wrapper ">
                            <span class="p-2">New Email: </span><input type="text" placeholder="Enter new email" name="email">
                        </div>
                        <li>
                            <button type="submit" id="submitbtn" name="emailUpdateBtn" class="button-text mt-4">Submit</button>
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