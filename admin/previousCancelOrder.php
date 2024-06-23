<?php 
include('includes/header.php');
include('../middleware/adminMid.php');

$orders = getOrderTime("order_transac", "Cancelled");
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
                            <a class="nav-link" href="orders.php" style="color:black;">Pending Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="deliverOrder.php" style="color:black;">Orders for Delivery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="completedOrders.php" style="color:black;">Completed Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Cancelled Orders</a>
                        </li>
                    </ul>
                    <!--------------- PRODUCTS TABLE --------------->
                    <h6 style="font-family: 'Suez One', sans-serif; font-size: 30px; padding-top:20px;">Cancelled Orders</h6>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="cancelledOrders.php" style="color:black;">Recent Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#" style="color:black;">Previous Orders</a>
                        </li>
                    </ul>
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Order Status</th>
                                <th>Items</th>
                                <th>Order Date</th>
                                <th>Details</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                                    <?php
                                    if ($orders['recentOrders'] && mysqli_num_rows($orders['pastOrders']) > 0) {
                                        while ($order = mysqli_fetch_assoc($orders['pastOrders'])) {
                                    ?>
                                    <tr style="text-align: center; vertical-align: middle;">
                                        <td><?= $order['order_id']; ?></td>
                                        <td><?= $order['user_name']; ?></td>
                                        <td><?= $order['status']; ?></td>
                                        <td><?= $order['product_name']; ?></td>
                                        <td><?= formatDate($order['order_at']); ?></td>
                                        <td>
                                            <a href="completeCancelledDetails.php?id=<?= $order['order_transac_id']; ?>" style="margin-top: 10px;" class="btn bg-primary text-white">View Details</a>
                                        </td>
                                        <td>
                                            <form action="codes.php" method="POST">
                                                <input type="hidden" name="order_transac_id" value="<?= $order['order_transac_id']; ?>">
                                                <button type="submit" class="btn btn-danger text-white" style="margin-top: 10px;" name="deleteCancelledTransacOrder_button">Delete</button>
                                            </form>
                                        </td>
                                        </tr>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                    <tr>
                                        <td colspan="7">No recent orders found</td>
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
