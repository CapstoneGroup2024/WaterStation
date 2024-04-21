<?php

include('../config/dbconnect.php');
include('../functions/myAlerts.php');

if(isset($_POST['addCateg_button'])){ 
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1':'0'; // If the status is not null
    $popular = isset($_POST['popular']) ? '1':'0'; // If popular is not null
    
    $image = $_FILES['image']['name']; 

    $path = "../uploads"; // IMAGES FOLDER
    $image_ext = pathinfo($image, PATHINFO_EXTENSION); // GIVE THE IMAGE EXTENSION
    $filename = time().'.'.$image_ext;

    $categ_query = "INSERT INTO categories
    (name,slug,description,meta_title,meta_description,meta_keywords,status,popular,image)
    VALUES ('$name','$slug','$description','$meta_title','$meta_description','$meta_keywords','$status','$popular','$filename')";

    $categ_query_run = mysqli_query($con, $categ_query);

    if($categ_query_run){
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename);
        redirect("addCategory.php", "Category added successfully");
    } else{
        redirect("addCategory.php", "Something went wrong");
    }


}

?>