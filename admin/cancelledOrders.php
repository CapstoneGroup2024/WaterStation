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
                            <a class="nav-link" href="completedOrders.php" style="color:black;">Completed Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Cancelled Orders</a>
                        </li>
                    </ul>
                    <!--------------- PRODUCTS TABLE --------------->
                    <h6 style="font-family: 'Suez One', sans-serif; font-size: 30px; padding-top:20px;">Completed Orders</h6>
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Order Status</th>
                                <th>Items</th>
                                <th>Details</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $orders = getOrderData("order_transac"); // FUNCTION TO FETCH ORDER DATA FROM THE DATABASE
                            if(mysqli_num_rows($orders) > 0) { // CHECK IF THERE ARE ANY ORDERS
                                foreach($orders as $order) {
                                    if ($order['status'] == 'Cancelled') { // ITERATE THROUGH EACH ORDER
                            ?>
                            <tr style="text-align: center; vertical-align: middle;">
                                <td><?= $order['order_transac_id']; ?></td>
                                <td><?= $order['user_name']; ?></td> <!-- Display user's name -->
                                <td><?= $order['status']; ?></td> <!-- Assuming status exists in the transaction details -->
                                <td><?= $order['product_name']; ?></td> <!-- Assuming product_name exists in the transaction details -->
                                <td>
                                    <a href="completeCancelledDetails.php?id=<?= $order['order_transac_id']; ?>" style="margin-top: 10px;" class="btn bg-primary text-white">View Details</a>
                                </td>
                                <td>
                                    <form action="codes.php" method="POST">
                                        <input type="hidden" name="order_id" value="<?= $order['order_transac_id']; ?>">
                                        <button type="submit" class="btn btn-danger text-white" style="margin-top: 10px;" name="deleteOrder_button">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                        }
                                    }
                            } else {
                            ?>
                            <tr>
                                <td colspan="6">No completed orders found</td>
                            </tr>
                            <?php
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
