<?php 
    include('includes/header.php');
    include('../middleware/adminMid.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Category</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6"> <!-- Changed to col-lg-6 for half width -->
                            <div class="form-group">
                                <label for="name1">Name</label>
                                <input type="text" class="form-control" id="addCateg_name">
                            </div>
                        </div>
                        <div class="col-lg-6"> <!-- Changed to col-lg-6 for half width -->
                            <div class="form-group">
                                <label for="name2">Slug</label>
                                <input type="text" class="form-control" id="addCateg_slug">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php');?>
