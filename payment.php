<?php
session_start();

// Check authentication
if (!isset($_SESSION['auth'])) {
    $_SESSION['message'] = "Please login first";
    header('Location: index.php');
    exit();
}

// INCLUDE NECESSARY FILES
include('includes/header.php');
include('includes/orderbar.php');
include('functions/userFunctions.php');

// GET USER ID FROM SESSION
$userId = $_SESSION['user_id'];

// FUNCTION TO GET USER DETAILS
function getUserDetails($userId) {
    global $con;

    // Check if $con is a valid MySQLi connection
    if (!$con) {
        echo "Error: MySQLi connection is not established.";
        return false;
    }

    // QUERY TO SELECT USER DETAILS FOR A SPECIFIC USER
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the query executed successfully
    if (!$result) {
        echo "Error executing query: " . mysqli_error($con);
        return false;
    }

    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        $userDetails = mysqli_fetch_assoc($result);
        return $userDetails;
    } else {
        // DISPLAY ERROR MESSAGE IF NO USER DETAILS FOUND
        echo "No user details found for user ID: $userId";
        return false;
    }
}

// Reconnect to the database if necessary
if (mysqli_connect_errno()) {
    include('config/dbconnect.php'); // Assuming dbconnect.php contains the connection code
}

$userDetails = getUserDetails($userId);

if ($userDetails) {
    // Fetch order details from session
    if(isset($_GET['id'])){
        $order_id = $_GET['id'];

        // Call getOrderDetails to fetch order details
        $orderDetails = getOrderDetails($con, $order_id);

        $orderStatus = $orderDetails['orderStatus'];
        $subtotal = $orderDetails['orderSubTotal'];
        $additional_fee = $orderDetails['orderAddFee'];
        $grandtotal = $orderDetails['orderGrandTotal'];

        // Check if the status is available
        if ($orderStatus !== "Not available") {
            // Display the order status
            echo "Order Status: " . $orderStatus;
        } else {
            // Display a message if the status is not available
            echo "Order status is not available.";
        }
        // Display order receipt
        ?>

        
        <section class="p-5 p-md-5 text-sm-start">
            <div class="container" style="margin-top: 60px;">
                <div class="row">
                    <div class="col-md-10">
                        <h1 style="font-family: 'suez one'; color: #013D67;"><i class="fas fa-shopping-cart"></i> Payment Details</h1>
                    </div>
                </div>
                <!-- Display delivery details -->
                <div class="row" style="width: 300px; display: flex; float:left;">
                    <div class="card-body shadow p-3 mt-4" style="border-radius: 20px; font-family: 'Poppins';">
                        <div class="col align-items-center p-2">
                            <h4>Delivery Details</h4>
                            <div class="row-md-2 p-1" style="margin-top: 20px; margin-left: 10px">
                                <h6>Customer Name: <br><?= $userDetails['name'] ?></h6>
                            </div>
                            <div class="row-md-2 p-1" style="margin-top: -10px; margin-left: 12px">
                                <h6>Contact Number: <br><?= $userDetails['phone'] ?></h6>
                            </div>
                            <div class="row-md-2 p-1" style="margin-top: -10px; margin-left: 12px">
                                <h6>Address: <br><?= $userDetails['address'] ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="width: 300px; display: flex; float:left">
                    <div class="card-body shadow p-3 mt-4" style="border-radius: 20px; font-family: 'Poppins';">
                        <div class="col align-items-center p-2">
                            <h4>Order Status</h4>
                            <div class="row-md-2 p-1" style="margin-top: 20px; margin-left: 10px">
                                <h6><?= $orderStatus ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                
                    <div class="card shadow-sm p-3" style="padding-left: 10px; width: 780px; border-radius: 20px; display: flex; float:right; margin-bottom: 20px">    
                        <div class="row align-items-center p-2">
                        <h4>Order Summary</h4>
                            <div class="col-md-4">
                                <h6 style="font-family: 'Poppins'; font-size: 22px;">Quantity</h6>
                            </div>
                            <div class="col-md-4">
                                <h6 style="font-family: 'Poppins'; font-size: 22px;">Items</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 style="font-family: 'Poppins'; font-size: 22px;">Price</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 style="font-family: 'Poppins'; font-size: 22px;">Total</h6>
                            </div>
                        </div>
                    </div>        
                    <!-- Display order summary -->
                    <?php
                    // Fetch cart items from the session
                    $cartItems = getProductsByOrderId($order_id);
                    ?>               
                        <?php foreach ($cartItems as $cartItem) { 
                            
                            $itemTotal = $cartItem['quantity'] * $cartItem['price'];
                            ?>
                            
                            <div class="card shadow-sm p-3" style=" width: 780px; border-radius: 20px; display: flex; float:right; margin-bottom: 20px;">
                                <div class="row align-items-center ">
                                    <div class="col-md-3" style="padding-left: 50px; margin-bottom: 0px">
                                        <h5><?= $cartItem['quantity'] ?></h5>
                                    </div>
                                    <div class="col-md-2">
                                        <img src="uploads/<?= $cartItem['product_image'] ?>" width="80px" alt="<?= $cartItem['product_name'] ?>" style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-3">
                                        <h5><?= $cartItem['product_name'] ?></h5>
                                    </div>
                                    <div class="col-md-2">
                                        <h5><?= $cartItem['price'] ?></h5>
                                    </div>
                                    <!-- Access total_price instead of total -->
                                    <div class="col-md-2">
                                        <h5>₱<?= $itemTotal ?></h5>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                </div>
                <!-- Display subtotal, delivery fee, and grand total -->
                <div class="container mt-4">
                    <div class="card-body shadow p-3" style="border-radius: 20px; width: 780px; display: flex; float:right; margin-top: 20px">
                        <div class="col align-items-center p-2">
                            <div class="row-md-2 shadow-sm p-2" style="padding-top: 20px; margin-bottom: 0px; border-radius: 8px; align-items:center;">
                                <h5>Subtotal: <span class="subtotal-price" style="display: flex; float:right;">₱<?= $subtotal ?></span></h5>
                            </div>
                            <div class="row-md-2 shadow-sm p-2" style="padding-top: 20px; margin-bottom: 0px; border-radius: 8px; align-items:center;">
                                <h5>Delivery Fee: <span class="delivery-fee" style="display: flex; float:right;">₱<?= $additional_fee ?></span></h5>
                            </div>
                            <div class="row-md-2 shadow-sm p-2" style="padding-top: 20px; margin-bottom: 0px; border-radius: 8px; align-items:center;">
                                <h5>Grand Total: <span class="grand-total" style="display: flex; float:right;">₱<?= $grandtotal ?></span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    } else {
        echo "<p>No order details found.</p>";
    }
} else {
    echo "<p>No user details found.</p>";
}

// INCLUDE FOOTER?>
<!--------------- ALERTIFY JS --------------->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
    <?php
        if (isset($_SESSION['message'])) { // CHECK IF SESSION MESSAGE VARIABLE IS SET
    ?>
    alertify.alert('AquaFlow', '<?= $_SESSION['message']?>').set('modal', true).set('movable', false); // DISPLAY MESSAGE MODAL
    <?php
        unset($_SESSION['message']); // UNSET THE SESSION MESSAGE VARIABLE
        }
    ?>
</script>
<?php
include('includes/footer.php');
?>
