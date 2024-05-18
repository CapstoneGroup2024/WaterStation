<!--------------- INCLUDES --------------->
<?php include('includes/header.php');?>

<link rel="stylesheet" href="assets/css/verification.css">
<script src="verification.js" defer></script>
<?php // RESTRICT USER ACCESSING THIS PAGE THROUGH URL
    if(isset($_SESSION['auth'])){
        $_SESSION['message'] = "You are already logged in";
        header('Location: homepage.php');
        exit();
    }
?> 
<!--------------- REGISTER FORM --------------->
<div class="container">
      <header>
        <i class="bx bxs-check-shield"></i>
      </header>
      <h4>Enter OTP Code</h4>
      <form action="#">
        <div class="input-field">
          <input type="number" autofocus/>
          <input type="number" disabled />
          <input type="number" disabled />
          <input type="number" disabled />
          <input type="number" disabled />
          <input type="number" disabled />
        </div>
        <button>Verify OTP</button>
      </form>
    </div>
 <!--------------- FOOTER --------------->
<?php include('includes/footer.php');?>