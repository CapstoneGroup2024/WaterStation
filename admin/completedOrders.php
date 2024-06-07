<?php 
    include('includes/header.php');
    include('../middleware/adminMid.php');
?>
<!--------------- PRODUCT PAGE --------------->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4 style="font-family: 'Suez One', sans-serif; font-size: 35px;">Orders</h4>
                </div>
                <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php" style="color:black;">Ongoing Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Completed Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cancelledOrders.php" style="color:black;">Cancelled Orders</a>
                    </li>
                    </ul>
                    <!--------------- PRODUCTS TABLE --------------->
                    <h6 style="font-family: 'Suez One', sans-serif; font-size: 30px; padding-top:20px;">Completed Orders</h6>
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Order Status</th>
                                <th>Details</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php            
                            // GET DATA FOR ORDERS
                            $orders = getOrderData("orders"); // FUNCTION TO FETCH ORDER DATA FROM THE DATABASE
                            if(mysqli_num_rows($orders) > 0){ // CHECK IF THERE ARE ANY ORDERS
                                foreach($orders as $order){
                                    if ($order['status'] == 'Completed'){// ITERATE THROUGH EACH ORDER
                                        // Fetch user details for the current order
                                        $userDetails = getUserDetails($order['user_id']);
                                        $product = getFirstProductByOrderId($order['id']);
                                        if($userDetails ){
                                            if($product){
                            ?>
                                        <tr>
                                            <td><?= $order['id']; ?></td>
                                            <td><?= $userDetails['name']; ?></td> <!-- Display user's name -->
                                            <td><?= $order['status']; ?></td>
                                            <td><?= $product['product_name']; ?></td>
                                            <td>
                                                <a href="orderDetails.php?id=<?= $order['id']; ?>" class="btn bg-primary text-white">View Details</a>
                                            </td>
                                            <td>
                                                <form action="codes.php" method="POST">
                                                    <input type="hidden" name="order_id" value="<?= $order['id'];?>">
                                                    <button type="submit" class="btn btn-danger text-white" name="deleteOrder_button">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                            <?php
                                        } else{
                                            echo "Error: Failed to fetch product details for user ID: " . $order['user_id'];
                                        }
                                    }
                                        else {
                                            // Handle case when user details are not found
                                            echo "Error: Failed to fetch user details for user ID: " . $order['user_id'];
                                        }
                                    }
                                }
                            } else {
                                echo "No ongoing orders found";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------------- FOOTER --------------->
<?php include('includes/footer.php');?>
