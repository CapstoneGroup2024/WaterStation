<?php 
    include('includes/header.php');
    include('../middleware/adminMid.php');
?>
<!--------------- CATEGORY PAGE --------------->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4 style="font-family: 'Suez One', sans-serif; font-size: 35px;">Categories</h4>
                </div>
                <div class="card-body">
                    <!--------------- CATEGORY TABLE --------------->
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // GET DATA FOR CATEGORIES
                                $category = getData("categories"); // FUNCTION TO FETCH CATEGORY DATA FROM THE DATABASE
                                if(mysqli_num_rows($category) > 0){ // CHECK IF THERE ARE ANY CATEGORIES
                                    foreach($category as $item){ // ITERATE THROUGH EACH CATEGORY
                            ?>
                                        <tr>
                                            <td><?= $item['id']; ?></td>
                                            <td><?= $item['name']; ?></td>
                                            <td>
                                                <img src="../uploads/<?= $item['image']; ?>" width="50px" height="50px" alt="<?= $item['name']; ?>">
                                            </td>
                                            <td>
                                                <?= $item['status'] == '0'? "Out of Stock": "Available"; ?>
                                            </td>
                                            <td>
                                                <a href="editCategory.php?id=<?= $item['id']; ?>" class="btn bg-primary text-white">Edit</a>
                                            </td>
                                            <td>
                                                <form action="codes.php" method="POST">
                                                    <input type="hidden" name="category_id" value="<?= $item['id'];?>">
                                                    <button type="submit" class="btn btn-danger text-white" name="deleteCategory_button">Delete</button>
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
