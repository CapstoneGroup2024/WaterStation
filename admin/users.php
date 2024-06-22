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
                    <h4 style="font-family: 'Suez One', sans-serif; font-size: 35px;">Users</h4>
                </div>
                <div class="card-body">
                    <!--------------- PRODUCTS TABLE --------------->
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr style="text-align: center; vertical-align: middle;">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>View Details</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                $users = getData("users"); // FUNCTION TO FETCH CATEGORY DATA FROM THE DATABASE
                                if(mysqli_num_rows($users) > 0){ // CHECK IF THERE ARE ANY CATEGORIES
                                    foreach($users as $item){ // ITERATE THROUGH EACH CATEGORY

                                    $user_id = $item['user_id'];
                                    // Fetch current role from the database
                                    $query = "SELECT role FROM users WHERE user_id = $user_id"; // Adjust table and column names as per your database structure
                                    $result = mysqli_query($con, $query);

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                        $current_role = $row['role'];
                                    } else {
                                        $current_role = null; // Handle case where user's role is not found or query fails
                                    }

                                    // Define role options based on your application's role definitions
                                    $roleOptions = [
                                        1 => 'Admin',
                                        0 => 'User'
                                    ];

                            ?>
                            
                                        <tr style="text-align: center; vertical-align: middle;">
                                            <td name="product_id"><?= $item['user_id']; ?></td>
                                            <td><?= $item['name']; ?></td>
                                            <td>
                                                <form action="codes.php" method="POST">
                                                    <input type="hidden" name="user_id" value="<?= $item['user_id']; ?>">
                                                    <select name="user_role" style="padding: 8px; border-radius: 10px;">
                                                        <option value="1" <?= ($item['role'] == 1) ? 'selected' : ''; ?>>Admin</option>
                                                        <option value="0" <?= ($item['role'] == 0) ? 'selected' : ''; ?>>User</option>
                                                    </select>
                                                    <input type="submit" class="btn bg-primary text-white" name="updateRole" value="Update">
                                                </form>
                                            </td>
                                            <td>
                                                <a href="userDetails.php?id=<?= $item['user_id']; ?>"style="margin-top: 10px;" class="btn bg-primary text-white">View Details</a>
                                            </td>
                                            <td>
                                                <form action="codes.php" method="POST">
                                                    <input type="hidden" name="customer_id" value="<?= $item['user_id'];?>">
                                                    <button type="submit" class="btn btn-danger text-white" name="deleteUser_button">Delete</button>
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
