<?php 
    include('includes/header.php');
    include('../middleware/adminMid.php');

    if(isset($_GET['id'])){
        $order_transac_id = $_GET['id']; // Assuming the order ID is passed in the URL parameter 'id'
    
        // Fetch the order details including the user_id
        $query = "SELECT * FROM order_transac WHERE order_transac_id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'i', $order_transac_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $orderDetails = mysqli_fetch_assoc($result);

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
                                                <h6>Customer Name: <br><?= $orderDetails['user_name'] ?></h6>
                                            </div>
                                            <div class="row-md-2 p-1" style="margin-top: -10px; margin-left: 12px">
                                                <h6>Contact Number: <br><?= $orderDetails['phone'] ?></h6>
                                            </div>
                                            <div class="row-md-2 p-1" style="margin-top: -10px; margin-left: 12px">
                                                <h6>Address: <br><?= $orderDetails['address'] ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="width: 300px; display: flex; float:right">
                                        <div class="card-body p-3 mt-4" style="border-radius: 20px;">
                                            <div class="col align-items-center p-2">
                                                <h4>Order Status</h4>
                                                <div class="row-md-2 p-1" style="margin-top: 20px; margin-left: 10px">
                                                    <h6><?= $orderDetails['status'] ?></h6>
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

                                <!-- Display order items -->
                                <?php
                                    // Fetch order items for the given order_transac_id
                                    $query = "SELECT * FROM order_transac WHERE order_id = ?";
                                    $stmt = mysqli_prepare($con, $query);
                                    mysqli_stmt_bind_param($stmt, 'i', $orderDetails['order_id']);
                                    mysqli_stmt_execute($stmt);
                                    $itemsResult = mysqli_stmt_get_result($stmt);

                                    if ($itemsResult && mysqli_num_rows($itemsResult) > 0) {
                                        while ($item = mysqli_fetch_assoc($itemsResult)) {
                                            $itemTotal = $item['quantity'] * $item['price'];
                                ?>
                                            <div class="card p-1 text-center" style="box-shadow: none; width: 600px; border-radius: 20px; display: flex; float:left;">
                                                <div class="row align-items-center ">
                                                    <div class="col-md-2" style="padding-left: 50px; margin-bottom: 0px">
                                                        <h5><?= $item['quantity'] ?></h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5><?= $item['product_name'] ?></h5>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <h5><?= $item['price'] ?></h5>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <h5>₱<?= $itemTotal ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                <?php
                                        }
                                    } else {
                                        echo "No items found for this order.";
                                    }
                                ?>
                                <!-- Display subtotal, delivery fee, and grand total -->
                                <div class="card-body p-3" style="border-radius: 20px; width: 600px; display: flex; float:left; margin-top: 20px">
                                    <div class="col align-items-center p-2">
                                        <div class="row-md-2  p-2" style="padding-top: 20px; margin-bottom: 0px; border-radius: 8px; align-items:center;">
                                            <h5>Subtotal: <span class="subtotal-price" style="display: flex; float:right;">₱<?= $orderDetails['subtotal'] ?></span></h5>
                                        </div>
                                        <div class="row-md-2  p-2" style="padding-top: 20px; margin-bottom: 0px; border-radius: 8px; align-items:center;">
                                            <h5>Delivery Fee: <span class="delivery-fee" style="display: flex; float:right;">₱<?= $orderDetails['additional_fee'] ?></span></h5>
                                        </div>
                                        <div class="row-md-2  p-2" style="padding-top: 20px; margin-bottom: 0px; border-radius: 8px; align-items:center;">
                                            <h5>Total: <span class="grand-total" style="display: flex; float:right;">₱<?= $orderDetails['grand_total'] ?></span></h5>
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
