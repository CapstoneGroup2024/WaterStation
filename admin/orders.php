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
                    <!--------------- PRODUCTS TABLE --------------->
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Delivery Fee</th>
                                <th>Grand Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                                // GET DATA FOR CATEGORIES
                                $order = getData("orders"); // FUNCTION TO FETCH CATEGORY DATA FROM THE DATABASE
                                if(mysqli_num_rows($order) > 0){ // CHECK IF THERE ARE ANY CATEGORIES
                                    foreach($order as $item){ // ITERATE THROUGH EACH CATEGORY
                            ?>
                                        <tr>
                                            <td><?= $item['id']; ?></td>
                                            <td><?= $item['user_id']; ?></td>
                                            <td><?= $item['product_id']; ?></td>
                                            <td><?= $item['quantity']; ?></td>
                                            <td><?= $item['subtotal']; ?></td>
                                            <td><?= $item['delivery_fee']; ?></td>
                                            <td><?= $item['grand_total']; ?></td>
                                        </tr>
                            <?php
                                    }
                                } else{
                                    echo "No records found";
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
