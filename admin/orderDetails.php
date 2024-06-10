<?php 
    include('includes/header.php');
    include('../middleware/adminMid.php');

    function getUserDetail($user_id) {
        global $con;
    
        // Check if $con is a valid MySQLi connection
        if (!$con) {
            echo "Error: MySQLi connection is not established.";
            return false;
        }
    
        // QUERY TO SELECT USER DETAILS FOR A SPECIFIC USER
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
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
            echo "No user details found for user ID:";
            return false;
        }
    }
    
    function getItemsCart($order_id) {
        global $con;
    
        // QUERY TO SELECT CART ITEMS FOR A SPECIFIC ORDER
        $query = "SELECT oi.*, oi.total AS total_price FROM order_items oi WHERE oi.order_id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'i', $order_id); 
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        if ($result && mysqli_num_rows($result) > 0) {
            return $result; // Return the result set
        } else {
            // DISPLAY ERROR MESSAGE IF QUERY FAILED
            echo "Error retrieving cart items: " . mysqli_error($con);
            return false;
        }
    }

    if(isset($_GET['id'])){
        $order_id = $_GET['id']; // Assuming the order ID is passed in the URL parameter 'id'
    
        // Fetch the order details including the user_id
        $query = "SELECT user_id, status, subtotal, additional_fee, grand_total FROM orders WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'i', $order_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $orderStatus = $row['status'];
            $user_id = $row['user_id'];
            $subtotal = $row['subtotal'];
            $additional_fee = $row['additional_fee'];
            $grand_total = $row['grand_total'];
    
            // Now you have the user_id and order details, you can proceed to fetch user details and other necessary data
            $userDetails = getUserDetail($user_id);
            // Proceed with the rest of your code using $userDetails and $orderStatus
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mt-4">
                            <div class="card-header">
                                <h4 style="font-family: 'Suez One', sans-serif; font-size: 35px;">Order Details</h4>
                            </div>
                            <div class="card-body">
                                <!-- Display delivery details -->
                                <div class="row" style="width: 300px; display: flex; float:right;">
                                    <div class="card-body p-3 mt-4" style="border-radius: 20px;">
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
                                    <div class="row" style="width: 300px; display: flex; float:right">
                                        <div class="card-body p-3 mt-4" style="border-radius: 20px;">
                                            <div class="col align-items-center p-2">
                                                <h4>Order Status</h4>
                                                <div class="row-md-2 p-1" style="margin-top: 20px; margin-left: 10px">
                                                    <h6><?= $orderStatus ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card" style="box-shadow: none; padding-left: 10px; width: 600px; border-radius: 20px; display: flex; float:left;">    
                                    <div class="row align-items-center p-2">
                                        <div class="col-md-4">
                                            <h6 style=" font-size: 22px;">Quantity</h6>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 style=" font-size: 22px;">Items</h6>
                                        </div>
                                        <div class="col-md-2">
                                            <h6 style="font-size: 22px;">Price</h6>
                                        </div>
                                        <div class="col-md-2">
                                            <h6 style=" font-size: 22px;">Total</h6>
                                        </div>
                                    </div>
                                </div>        

                                <!-- Display order summary -->
                                <?php
                                // Fetch cart items from the session
                                $cartItems = getCartItemsByUserId($user_id);
                                $getTotal =  getItemsCart($order_id);
                                ?>               
                                <?php while ($cartItem = mysqli_fetch_assoc($cartItems)) { 
                                    $itemTotal = $cartItem['quantity'] * $cartItem['selling_price'];
                                ?>
                                    <div class="card p-1 text-center" style="box-shadow: none; width: 600px; border-radius: 20px; display: flex; float:left;">
                                        <div class="row align-items-center ">
                                            <div class="col-md-2" style="padding-left: 50px; margin-bottom: 0px">
                                                <h5><?= $cartItem['quantity'] ?></h5>
                                            </div>
                                            <div class="col-md-6">
                                                <h5><?= $cartItem['product_name'] ?></h5>
                                            </div>
                                            <div class="col-md-2">
                                                <h5><?= $cartItem['selling_price'] ?></h5>
                                            </div>
                                            <!-- Access total_price instead of total -->
                                            <div class="col-md-2">
                                                <h5>₱<?= $itemTotal ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- Display subtotal, delivery fee, and grand total -->
                                <div class="card-body p-3" style="border-radius: 20px; width: 600px; display: flex; float:left; margin-top: 20px">
                                    <div class="col align-items-center p-2">
                                        <div class="row-md-2  p-2" style="padding-top: 20px; margin-bottom: 0px; border-radius: 8px; align-items:center;">
                                            <h5>Subtotal: <span class="subtotal-price" style="display: flex; float:right;">₱<?= $subtotal ?></span></h5>
                                        </div>
                                        <div class="row-md-2  p-2" style="padding-top: 20px; margin-bottom: 0px; border-radius: 8px; align-items:center;">
                                            <h5>Delivery Fee: <span class="delivery-fee" style="display: flex; float:right;">₱<?= $additional_fee ?></span></h5>
                                        </div>
                                        <div class="row-md-2  p-2" style="padding-top: 20px; margin-bottom: 0px; border-radius: 8px; align-items:center;">
                                            <h5>Total: <span class="grand-total" style="display: flex; float:right;">₱<?= $grand_total ?></span></h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            echo "No order found with the specified ID.";
        }
    } else {
        echo "ID is missing from the URL.";
    }
?>

<!--------------- FOOTER --------------->
<?php include('includes/footer.php');?>
