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
                    <h4 style="font-family: 'Suez One', sans-serif; font-size: 35px;">Products</h4>
                </div>
                <div class="card-body">
                    <!--------------- PRODUCTS TABLE --------------->
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Image</th>
                                <th>Quantity</th>
                                <th>Original Price</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // GET DATA FOR CATEGORIES
                                $product = getData("product"); // FUNCTION TO FETCH CATEGORY DATA FROM THE DATABASE
                                if(mysqli_num_rows($product) > 0){ // CHECK IF THERE ARE ANY CATEGORIES
                                    foreach($product as $item){ // ITERATE THROUGH EACH CATEGORY
                            ?>
                                        <tr>
                                            <td name="product_id"><?= $item['id']; ?></td>
                                            <td><?= $item['name']; ?></td>
                                            <td><?= $item['size']; ?></td>
                                            <td>
                                                <img src="../uploads/<?= $item['image']; ?>" width="50px" height="50px" alt="<?= $item['name']; ?>">
                                            </td>
                                            <td><?= $item['quantity']?></td>
                                            <td>₱ <?= $item['original_price']; ?></td>
                                            <td>
                                                <?= $item['status'] == '0'? "Out of Stock": "Available"; ?>
                                            </td>
                                            <td>
                                                <a href="editProduct.php?id=<?= $item['id']; ?>" class="btn bg-primary text-white">Edit</a>
                                            </td>
                                            <td>
                                                <form action="codes.php" method="POST">
                                                    <input type="hidden" name="product_id" value="<?= $item['id'];?>">
                                                    <button type="submit" class="btn btn-danger text-white" name="deleteProduct_button">Delete</button>
                                                </form>
                                            </td>
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
