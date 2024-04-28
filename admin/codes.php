<?php

include('../config/dbconnect.php');
include('../functions/myAlerts.php');

if(isset($_POST['addCateg_button'])){ // IF FORM SUBMIT IS FROM addCateg_button
    $name = $_POST['name'];
    $slug = $_POST['slug'];  
    $description = $_POST['description'];
    $image = $_POST['image'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1':'0'; // IF THE STATUS IS SET AND NOT NULL
    $popular = isset($_POST['popular']) ? '1':'0'; // IF THE POPULAR IS SET AND NOT NULL
    
    $image = $_FILES['image']['name']; // GET THE ORIGINAL NAME OF THE UPLOADED FILE 

    $path = "../uploads"; // DEFINE THE DIRECTORY WHERE UPLOADED IMAGES IN WILL BE STORED 
    
    $image_ext = pathinfo($image, PATHINFO_EXTENSION); // GET THE FILE EXTENSION OF THE UPLOADED IMAGE 
    $filename = time().'.'.$image_ext; // GENERATE A UNIQUE FILENAME FOR THE UPLOADED IMAGE BY APPEDING THE CURRENT TIMESTAMP AND THE ORIGINAL FILE EXT
    
    $categ_query = "INSERT INTO categories
        (name,slug,description,meta_title,meta_description,meta_keywords,status,popular,image)
        VALUES ('$name','$slug','$description','$meta_title','$meta_description','$meta_keywords','$status','$popular','$filename')"; 
    
    $categ_query_run = mysqli_query($con, $categ_query); // EXECURE THE SQL QUERY TO INSERT CATEGORY INFORMATION INTO THE DATABASE 
    
    if($categ_query_run){
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename); // MOVE THE UPLOADED IMAGE FILE FROM THE TEMPORARY DIRECTORY TO THE SPECIFIED UPLOAD DIRECTORY WITH GENERATED FILE NAME 
        redirect("addCategory.php", "Category added successfully"); 
    } else{
        redirect("addCategory.php", "Something went wrong"); 
    }
} else if(isset($_POST['editCateg_button'])){
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];  
    $description = $_POST['description'];
    $image = $_POST['image'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1':'0'; // IF THE STATUS IS SET AND NOT NULL
    $popular = isset($_POST['popular']) ? '1':'0'; // IF THE POPULAR IS SET AND NOT NULL

    $new_image = $_FILES['image']['name']; // GET THE ORIGINAL NAME OF THE UPLOADED FILE 
    $old_image = $_POST['old_image'];

    if($new_image != ""){
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION); // GET THE FILE EXTENSION OF THE UPLOADED IMAGE 
        $update_filename = time().'.'.$image_ext; // GENERATE A UNIQUE FILENAME FOR THE UPLOADED IMAGE BY APPEDING THE CURRENT TIMESTAMP AND THE ORIGINAL FILE EXT
    } else{
        $update_filename = $old_image;
    }

    $path = "../uploads";

    $update_query = "UPDATE categories SET name='$name', slug='$slug', description='$description', 
    meta_title='$meta_title', meta_description='$meta_description', meta_keywords='$meta_keywords', 
    status='$status', popular='$popular', image='$update_filename' WHERE id='$category_id' ";

    $update_query_run = mysqli_query($con, $update_query);

    if($update_query_run){
        if($_FILES['image']['name'] != ""){
            move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$update_filename);
            if(file_exists("../uploads/".$old_image)){
                unlink("../uploads/".$old_image);
            }
        }
        redirect("editCategory.php?id=$category_id","Category Updated Successfully");
    } else{
        redirect("editCategory.php?id=$category_id","Something went wrong");
    }
} else if(isset($_POST['deleteCategory_button'])){
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);

    $category_query = "SELECT * FROM categories WHERE id='$category_id'";
    $category_query_run = mysqli_query($con, $category_query);
    $category_data = mysqli_fetch_array($category_query_run);
    $image = $category_data['image'];

    // Delete the category
    $delete_query = "DELETE FROM categories WHERE id='$category_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if($delete_query_run){
        if(file_exists("../uploads/".$image)){
            unlink("../uploads/".$image);
        }
        
        // Get the last auto-increment value
        $last_id_query = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'aquaflowdb' AND TABLE_NAME = 'categories'";
        $last_id_result = mysqli_query($con, $last_id_query);
        $last_id_row = mysqli_fetch_assoc($last_id_result);
        $last_auto_increment_value = $last_id_row['AUTO_INCREMENT'];

        // Set the auto-increment value to the last deleted ID
        $alter_query = "ALTER TABLE categories AUTO_INCREMENT = $category_id";
        mysqli_query($con, $alter_query);

        redirect("category.php","Category Deleted Successfully");
    } else{
        redirect("category.php","Something went wrong");
    }
} else if(isset($_POST['addProduct_button'])){
    $name = $_POST['name'];
    $slug = $_POST['slug'];  
    $small_description = $_POST['small_description'];
    $description = $_POST['description'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $image = $_POST['image'];
    $quantity = $_POST['quantity'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1':'0'; // IF THE STATUS IS SET AND NOT NULL
    $trending = isset($_POST['trending']) ? '1':'0'; // IF THE TRENDING IS SET AND NOT NULL
    
    $image = $_FILES['image']['name']; // GET THE ORIGINAL NAME OF THE UPLOADED FILE 

    $path = "../uploads"; // DEFINE THE DIRECTORY WHERE UPLOADED IMAGES IN WILL BE STORED 
    
    $image_ext = pathinfo($image, PATHINFO_EXTENSION); // GET THE FILE EXTENSION OF THE UPLOADED IMAGE 
    $filename = time().'.'.$image_ext; // GENERATE A UNIQUE FILENAME FOR THE UPLOADED IMAGE BY APPEDING THE CURRENT TIMESTAMP AND THE ORIGINAL FILE EXT

    $product_query = "INSERT INTO product(name, slug, small_description, description, original_price, selling_price, quantity, meta_title, meta_description, meta_keywords, status, trending, image) 
    VALUES ('$name', '$slug', '$small_description', '$description', '$original_price', '$selling_price', '$quantity', '$meta_title', 
    '$meta_description', '$meta_keywords', '$status', '$trending', '$filename')";

    $product_query_run = mysqli_query($con, $product_query);
    
    if($product_query_run){
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename); // MOVE THE UPLOADED IMAGE FILE FROM THE TEMPORARY DIRECTORY TO THE SPECIFIED UPLOAD DIRECTORY WITH GENERATED FILE NAME 
        redirect("addProduct.php", "Product added successfully"); 
    } else{
        redirect("addProduct.php", "Something went wrong"); 
    }
}


?>