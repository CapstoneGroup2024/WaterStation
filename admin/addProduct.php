<?php 
    include('includes/header.php');
    include('../middleware/adminMid.php');
?>
<!--------------- ADD CATEGORY PAGE --------------->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
            <div class="card-header">
                <h4 style="font-family: 'Suez One', sans-serif; font-size: 35px;">Add Product</h4>
            </div>
                <div class="card-body">
                    <!--------------- FORM--------------->
                    <form action="codes.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Product Name" name="name">
                                </div>
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="">Size</label>
                                    <input type="text" class="form-control" placeholder="Enter Size" name="size">
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                    <label for="">Upload Image</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                    <label for="">Quantity</label>
                                    <input type="number" class="form-control" placeholder="Enter Quantity" name="quantity">
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                    <label for="">Original Price</label>
                                    <input type="text" class="form-control" placeholder="Enter Original Price" name="original_price" >
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                    <label for="">Selling Price</label>
                                    <input type="text" class="form-control" placeholder="Enter Selling Price" name="selling_price">
                                </div>
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="">Status (Check if Available) </label>
                                <input type="checkbox" name="status">
                                </div>
                            </div>
                            <!--------------- SAVE BUTTON--------------->
                            <div class="col-md-12">
                                <button type="submit" class="btn bg-primary mt-2 md-w-10 text-white" name="addProduct_button" id="addCategSave">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>  
        </div>
    </div>
</div>
<!--------------- FOOTER --------------->
<?php include('includes/footer.php');?>
