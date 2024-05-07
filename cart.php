<!--------------- INCLUDES --------------->
<?php
    include('includes/header.php');
    include('includes/orderbar.php');
    include('functions/userFunctions.php');

    if(!isset($_SESSION['auth'])) { // RESTRICT USER ACCESSING THIS PAGE THROUGH URL
        $_SESSION['message'] = "Please login to view your cart.";
        header("Location: login.php"); // REDIRECT TO LOGIN
        exit();
    }
    $userId = $_SESSION['user_id']; // GET USER ID FROM SESSION
?>

<section class="p-5 p-md-5 text-sm-start" id="Cart">
    <div class="container" style="margin-top: 60px;">
        <div class="row">
            <div class="col-md-12">
                <h1 style="font-family: 'suez one';color: #013D67;">Cart</h1>
            </div>
        </div>
        <!--------------- CART BODY --------------->
        <div class="card-body shadow">
            <div class="row align-items-center p-2">
                <div class="col-md-4">
                    <h6 style="font-family: 'Poppins'; font-size: 22px;">Items</h6>
                </div>
            <div class="col-md-2">
                <h6 style="font-family: 'Poppins'; font-size: 22px;">Category</h6>
            </div>
            <div class="col-md-1">
                <h6 style="font-family: 'Poppins'; font-size: 22px;">Price</h6>
            </div>
            <div class="col-md-2">
                <h6 style="font-family: 'Poppins'; font-size: 22px;">Quantity</h6>
            </div>
            <div class="col-md-1">
                <h6 style="font-family: 'Poppins'; font-size: 22px;">Total</h6>
            </div>
            <div class="col-md-2">
                <h6 style="font-family: 'Poppins'; font-size: 22px;">Remove</h6>
            </div>
        </div>
        <?php
            $cartItems = getCartItemsByUserId($userId); // GET CART ITEMS BASED ON USER ID

            if(mysqli_num_rows($cartItems) > 0){ // ITERATE THROUGH EACH ITEM
                foreach($cartItems as $cart){ 
        ?>
            <!--------------- CART ITEMS --------------->
            <div class="card shadow-sm mb-3 cart_data">
                <div class="row align-items-center p-3">
                    <div class="col-md-2">
                        <img src="uploads/<?= $cart['product_image']; ?>" width="80px" alt="<?= $cart['product_name']; ?>" style="border-radius: 10px;">
                    </div>
                    <div class="col-md-2">
                        <h5><?= $cart['product_name']; ?></h5>
                    </div>
                    <div class="col-md-2">
                        <h5><?= $cart['category_name']; ?></h5>
                    </div>
                    <div class="col-md-1">
                        <h5>₱<?= $cart['selling_price']; ?></h5>
                    </div>
                    <div class="col-md-2" id="qty">
                        <div class="input-group mb-1" style="width:115px;">
                            <button class="input-group-text decrement-btn">-</button>
                                <input type="text" class="form-control bg-white text-center input-qty" id="qty_<?= $cart['id']; ?>" value="<?= $cart['quantity']; ?>">
                            <button class="input-group-text increment-btn">+</button>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <h5>₱<?= $cart['selling_price']; ?></h5>
                    </div>
                    <div class="col-md-2">
                        <form action="admin/codes.php" method="POST">
                            <input type="hidden" name="cart_id" value="<?= $cart['id'];?>">
                            <button type="submit" class="btn btn-danger text-white" name="deleteOrderBtn">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php
                }
            } else {
                echo "No records found";
            }
        ?>
        </div>
    </div>
</section>

<!--------------- ALERTIFY JS --------------->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
<?php
    if(isset($_SESSION['message'])){ // CHECK IF SESSION MESSAGE VARIABLE IS SET
?>
    alertify.set('notifier','position', 'top-right');
    var notification = alertify.success('<i class="fas fa-check animated-check"></i> <?= $_SESSION['message']?>'); // DISPLAY MESSAGE NOTIF with animated check icon
    notification.getElementsByClassName('animated-check')[0].addEventListener('animationend', function() {
    this.classList.remove('animated-check');
    }); // Remove animation class after animation ends
<?php
    unset($_SESSION['message']); // UNSET THE SESSION MESSAGE VARIABLE
  }
?>
</script>
<script src="assets/js/cartQty.js"></script>
<!--------------- FOOTER --------------->
<?php include('includes/footer.php');?> 
