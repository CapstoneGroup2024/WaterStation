<!--------------- HEADER --------------->
<?php include('includes/header.php');?>
<!--------------- REGISTER FORM --------------->
<div class="Register">
    <h1 class="heading">Register Here!</h1>
    <form action="functions/authcode.php" method="POST">
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
            <!--------------- To LOGIN PAGE --------------->
            <div class="row">
                <div class="col">
                    <div class="register-link">
                        <p id="loginlink">Already have an account? <a href="index.html" id="link">Log in Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!--------------- FOOTER --------------->
<?php include('includes/footer.php');?>