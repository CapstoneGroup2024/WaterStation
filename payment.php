<!--------------- INCLUDES --------------->
<?php
    // INCLUDE NECESSARY FILES
    include('includes/header.php');
    include('includes/orderbar.php');
    include('functions/userFunctions.php');

    // GET USER ID FROM SESSION
    $userId = $_SESSION['user_id'];
?>
<section class="p-5 p-md-5 text-sm-start">
    <div class="container" style="margin-top: 60px;">
        <div class="row">
            <div class="col-md-10">
                <h1 style="font-family: 'suez one'; color: #013D67;"><i class="fas fa-shopping-cart"></i> Payment Details</h1>
            </div>
        </div>
        <?php
        // FETCH USER, ORDER, AND CART DETAILS
        $userDetails = getUserDetails($userId);
        $order = getOrderItemsByUserId($userId);
        $cartItems = getCartItemsByUserId($userId);
        
        if($userDetails && $order && $cartItems){ 
            // FETCH ORDER DETAILS
            $orderDetails = mysqli_fetch_assoc($order);
        ?>
        <div class="container" style="width: 300px; display: flex; float:left;">
            <div class="card-body shadow p-3 mt-4" style="border-radius: 20px; font-family: 'Poppins';">
                <div class="col align-items-center p-2">
                    <h4>Delivery Details</h4>
                    <div class="row-md-2 p-2 shadow-sm">
                        <h5>User Name: <?php echo $userDetails['name']; ?></h5>
                    </div>
                    <div class="row-md-2 p-2 shadow-sm">
                        <h5>Address: <?php echo $userDetails['address']; ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <?php
        // DISPLAY EACH CART ITEM
        foreach ($cartItems as $cartItem) {
        ?>
        <div class="container mt-4">
            <div class="card-body shadow p-3" style="width: 780px; border-radius: 20px; display: flex; float:right;">
                <div class="row align-items-center">
                    <h4>Order Summary</h4>
                    <div class="col-md-2">
                        <img src="uploads/<?php echo $cartItem['product_image']; ?>" width="80px" alt="<?php echo $cartItem['product_name']; ?>" style="border-radius: 10px;">
                    </div>
                    <div class="col-md-6">
                        <h5><?php echo $cartItem['product_name']; ?></h5>
                    </div>
                    <div class="col-md-2">
                        <h5><?php echo $cartItem['selling_price']; ?></h5>
                    </div>
                    <div class="col-md-2">
                        <h5><?php echo $cartItem['quantity']; ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="container mt-4">
            <div class="card-body shadow p-3" style="border-radius: 20px; width: 780px; display: flex; float:right; margin-top: 20px">
                <div class="col align-items-center p-2" >
                    <!-- DISPLAY SUBTOTAL -->
                    <div class="row-md-2 shadow-sm p-2" style="padding-top: 20px; margin-bottom: 0px; border-radius: 8px; align-items:center;">
                        <h5>Subtotal: <span class="subtotal-price" style="display: flex; float:right;"><?php echo $orderDetails['subtotal']; ?></span></h5>
                    </div>
                    <!-- DISPLAY DELIVERY FEE -->
                    <div class="row-md-2 shadow-sm p-2" style="padding-top: 20px; margin-bottom: 0px; border-radius: 8px; align-items:center;">
                        <h5>Delivery Fee: <span class="delivery-fee" style="display: flex; float:right;"><?php echo $orderDetails['delivery_fee']; ?></span></h5>
                    </div>
                    <!-- DISPLAY GRAND TOTAL -->
                    <div class="row-md-2 shadow-sm p-2" style="padding-top: 20px; margin-bottom: 0px; border-radius: 8px; align-items:center;">
                        <h5>Total: <span class="grand-total" style="display: flex; float:right;"><?php echo $orderDetails['grand_total']; ?></span></h5>
                    </div>
                </div>
            </div>
        </div>
        <?php
        } else {
            echo "No user details, order, or cart items found";
        }
        ?>
    </div>
</section>
<!--------------- FOOTER --------------->
<?php include('includes/footer.php');?>
