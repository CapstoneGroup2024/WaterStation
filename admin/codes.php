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
}
?>