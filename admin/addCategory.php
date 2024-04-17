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
                <!--------------- FIRST ROW --------------->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                        </div>
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label for="">Slug</label>
                                <input type="text" class="form-control" name="slug" id="slug">
                            </div>
                        </div>
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
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
                                <label for="">Meta Title</label>
                                <input type="text" class="form-control" name="meta_title" id="meta_title">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Meta Description</label>
                                <textarea class="form-control" name="meta_description" id="meta_description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label for="">Meta Keywords</label>
                                <textarea class="form-control" name="meta_keywords" id="meta_keywords" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label for="">Status</label>
                               <input type="checkbox" name="status">
                            </div>
                        </div>
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label for="">Popular</label>
                               <input type="checkbox" name="popular">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php');?>
