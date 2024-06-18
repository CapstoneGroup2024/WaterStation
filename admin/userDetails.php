<?php 
    include('includes/header.php');
    include('../middleware/adminMid.php');
?>
<!--------------- EDIT CATEGORY PAGE --------------->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
                if(isset($_GET['id'])){
                    $id = $_GET['id'];

                    $query = "SELECT * FROM users WHERE user_id='$id'";
                    $user = mysqli_query($con, $query);

                    if(mysqli_num_rows($user) > 0){
                        $data = mysqli_fetch_array($user);
            ?>  
                        <div class="card mt-4">
                        <div class="card-header">
                            <h4 style="font-family: 'Suez One', sans-serif; font-size: 35px;">User Details</h4>
                        </div>
                            <div class="card-body">
                                <!--------------- FORM--------------->
                                    <div class="row">
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <input type="hidden" name="category_id" value="<?=$data['user_id']; ?>">
                                                <label for="">Name</label>
                                                <input type="text" value="<?=$data['name']; ?>" class="form-control" name="name" id="name">
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="text" value="<?=$data['email']; ?>" class="form-control" name="email">
                                            </div>
                                        </div>
                                        <div class="col-md-12"> 
                                            <div class="form-group">
                                                <label for="">Address</label>
                                                <textarea class="form-control" name="address" id="description" rows="3"><?=$data['address']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4"> 
                                            <div class="form-group">
                                                <label for="">Role (Check if Admin) </label><br>
                                                <input type="checkbox" <?= $data['role'] ? "checked":""?> name="role">
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
            <?php
                    }else{
                        echo "Category not found";
                    }
                } else{
                    echo "ID missing from url";
                }
            ?>
        </div>
    </div>
</div>
<!--------------- FOOTER --------------->
<?php include('includes/footer.php');?>
