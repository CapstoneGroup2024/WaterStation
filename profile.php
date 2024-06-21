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
<link rel="stylesheet" href="assets/css/profile.css">   
<section class="p-5 p-md-5 text-sm-start mt-4">
    <div class="Register mt-4">
        <div class="heading">Profile Form</div>
        <div class="profile-card">
            <img src="assets/images/user.png" alt="Profile Picture">
            <h2 disabled style="margin-bottom: 20px"><?= isset($data['name']) ? $data['name'] : 'Your Name' ?></h2>
            <div class="editLink mb-3" style="margin-top: -20px;">
                <a href="editProfile.php" class="editDetails" style="text-decoration: none; color:black;">Edit Details</a>
            </div>
            <div class="regform">
                <ul>
                    <li>
                        <label for="username">Name:</label>
                        <div class="input-wrapper">
                            <input type="text" id="username" name="name" class="us" placeholder="Enter your name" value="<?= isset($data['name']) ? $data['name'] : '' ?>" disabled>
                        </div>
                        <label for="email">Email:</label>
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" class="us" placeholder="Enter your email" value="<?= isset($data['email']) ? $data['email'] : '' ?>" disabled>
                        </div>
                    </li>
                    <li>
                        <label for="address">Address:</label>
                        <div class="input-wrapper">
                            <input type="text" id="address" name="address" class="us" placeholder="Enter your address" value="<?= isset($data['address']) ? $data['address'] : '' ?>" disabled>
                        </div>
                        <label for="phone">Phone:</label>
                        <div class="input-wrapper">
                            <input type="text" id="phone" name="phone" class="us" placeholder="Enter your phone number" value="<?= isset($data['phone']) ? $data['phone'] : '' ?>" disabled>
                        </div>
                    </li>
                </ul>
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