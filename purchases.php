<!--------------- INCLUDES --------------->
<?php
    session_start();

    // INCLUDE NECESSARY FILES
    include('includes/header.php');
    include('includes/orderbar.php');
    include('functions/userFunctions.php');

    // GET USER ID FROM SESSION
    $userId = $_SESSION['user_id'];

    function getOrderData($table, $userId, $timestamp_column = 'order_at') {
        global $con; // Assuming $con is your database conne ction variable
    
        // Query to select data from the table by ID
        $query = "SELECT * FROM $table WHERE user_id='$userId' ORDER BY $timestamp_column DESC ";
    
        // Execute the query
        $result = mysqli_query($con, $query);
    
        // Check if the query was successful
        if ($result) {
            return $result; // Return the mysqli_result object
        } else {
            // Return false if query execution failed
            return false;
        }
    }
    
?>


<link rel="stylesheet" href="assets/css/transac.css">
<section class="p-5 p-md-5 text-sm-start" id="Purchases" style="margin-bottom: 100px">
    <form action="admin/codes.php" method="POST">
        <div class="container" style="margin-top: 60px;">
            <div class="row">
                <div class="col-md-10">
                    <h1 style="font-family: 'suez one';color: #013D67;"><i class="fas fa-shopping-cart"></i>Orders</h1>
                </div>
            </div>
            <div class="list-group list-group-horizontal-md text-center">
                    <a class="list-group-item list-group-item-action act" href="#">Pending Orders</a>
                    <a class="list-group-item list-group-item-action" href="deliverOrder.php" >Orders for Delivery</a>
                    <a class="list-group-item list-group-item-action" href="completedOrder.php" >Completed Orders</a>
                    <a class="list-group-item list-group-item-action" href="cancelOrder.php">Cancelled Orders</a>
            </div>

                
            

            <!--------------- ONGOING ORDERS --------------->
            <div class="card-body shadow">
                <h2 style="padding: 20px;">Pending Orders</h2>
                <div class="row align-items-center p-2 text-center">
                    <div class="col-md-1">
                        <h6 style="font-family: 'Poppins'; font-size: 22px;">No.</h6>
                    </div>
                    <div class="col-md-2">
                        <h6 style="font-family: 'Poppins'; font-size: 22px;">Items</h6>
                    </div>
                    <div class="col-md-3">
                        <h6 style="font-family: 'Poppins'; font-size: 22px;">Status</h6>
                    </div>
                    <div class="col-md-2">
                        <h6 style="font-family: 'Poppins'; font-size: 22px;">Total</h6>
                    </div>
                    <div class="col-md-2">
                        <h6 style="font-family: 'Poppins'; font-size: 22px;">Date</h6>
                    </div>
                    <div class="col-md-2">
                        <h6 style="font-family: 'Poppins'; font-size: 22px;">View Details</h6>
                    </div>
                </div>

                <?php
                $orderItems = getOrderData('orders', $userId); // GET ORDERS BASED ON USER ID

                if (mysqli_num_rows($orderItems) > 0) { // ITERATE THROUGH EACH ORDER
                    foreach ($orderItems as $order) {
                        if ($order['status'] == 'Ongoing') {
                            // Fetch the first product for this order
                            $productItem = getFirstProductByOrderId($order['id']);

                            // Check if productItem is not null before accessing its elements
                            if ($productItem !== null) {
                ?>
                                <!--------------- CART ITEMS --------------->
                                <div class="card shadow-sm mb-3 cart_data text-center">
                                    <div class="row align-items-center p-3">
                                        <div class="col-md-1">
                                            <h5><?= $order['id']; ?></h5>
                                        </div>
                                        <div class="col-md-2">
                                            <h5><?= $productItem['product_name']; ?></h5>
                                        </div>
                                        <div class="col-md-3">
                                            <h5><?= $order['status']; ?></h5>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>₱<?= $order['grand_total']; ?></h5>
                                        </div>
                                        <div class="col-md-2">
                                            <h5><?= $order['order_at']; ?></h5>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="payment.php?id=<?= $order['id']; ?>" class="btn bg-primary text-white">View Details</a>
                                        </div>
                                    </div>
                                </div>
                <?php
                            } else {
                                ?>
                                <div class="card shadow-sm mb-3 cart_data text-center">
                                    <div class="row align-items-center p-3">
                                        <div class="col-md-10">
                                            <h5 style="color:red;">No product found for order ID: <?= $order['id']; ?></h5>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="hidden" name="cart_id_<?= $cart['id']; ?>" value="<?= $cart['id']; ?>">
                                            <input type="submit" class="btn btn-danger text-white" name="deleteOngoingOrderBtn" value="Cancel Order"></input>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                } else {
                    echo "No ongoing orders found";
                }
?>
            </div>
            </div>
        </div>
    </form>
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
        }); // REMOVE ANIMATION CLASS AFTER ANIMATION ENDS
    <?php
        unset($_SESSION['message']); // UNSET THE SESSION MESSAGE VARIABLE
    }
    ?>
</script>
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
