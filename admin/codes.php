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
    $additional_price = $_POST['additional_price'];
    $status = isset($_POST['status']) ? '1':'0'; // IF THE STATUS IS SET AND NOT NULL
    $popular = isset($_POST['popular']) ? '1':'0'; // IF THE POPULAR IS SET AND NOT NULL
    
    $image = $_FILES['image']['name']; // GET THE ORIGINAL NAME OF THE UPLOADED FILE 

    $path = "../uploads"; // DEFINE THE DIRECTORY WHERE UPLOADED IMAGES IN WILL BE STORED 
    
    $image_ext = pathinfo($image, PATHINFO_EXTENSION); // GET THE FILE EXTENSION OF THE UPLOADED IMAGE 
    $filename = time().'.'.$image_ext; // GENERATE A UNIQUE FILENAME FOR THE UPLOADED IMAGE BY APPEDING THE CURRENT TIMESTAMP AND THE ORIGINAL FILE EXT
    
    $categ_query = "INSERT INTO categories
        (name,slug,description, meta_title,meta_description,meta_keywords, additional_price, status,popular,image)
        VALUES ('$name','$slug','$description','$meta_title','$meta_description','$meta_keywords', '$additional_price', '$status','$popular','$filename')"; 
    
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
    $additional_price = $_POST['additional_price'];
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
    additional_price='$additional_price', status='$status', popular='$popular', image='$update_filename' WHERE id='$category_id' ";

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
    $size = $_POST['size'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $image = $_POST['image'];
    $quantity = $_POST['quantity'];
    $meta_title = $_POST['meta_title'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1':'0'; // IF THE STATUS IS SET AND NOT NULL
    $trending = isset($_POST['trending']) ? '1':'0'; // IF THE TRENDING IS SET AND NOT NULL
    
    $image = $_FILES['image']['name']; // GET THE ORIGINAL NAME OF THE UPLOADED FILE 

    $path = "../uploads"; // DEFINE THE DIRECTORY WHERE UPLOADED IMAGES IN WILL BE STORED 
    
    $image_ext = pathinfo($image, PATHINFO_EXTENSION); // GET THE FILE EXTENSION OF THE UPLOADED IMAGE 
    $filename = time().'.'.$image_ext; // GENERATE A UNIQUE FILENAME FOR THE UPLOADED IMAGE BY APPEDING THE CURRENT TIMESTAMP AND THE ORIGINAL FILE EXT

    $product_query = "INSERT INTO product(name, slug, size, original_price, selling_price, quantity, meta_title, meta_keywords, status, trending, image) 
    VALUES ('$name', '$slug', '$size', '$original_price', '$selling_price', '$quantity', '$meta_title', 
    '$meta_keywords', '$status', '$trending', '$filename')";

    $product_query_run = mysqli_query($con, $product_query);

    if($product_query_run){
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename); // MOVE THE UPLOADED IMAGE FILE FROM THE TEMPORARY DIRECTORY TO THE SPECIFIED UPLOAD DIRECTORY WITH GENERATED FILE NAME 
        redirect("addProduct.php", "Product added successfully"); 
    } else{
        redirect("addProduct.php", "Something went wrong"); 
    }
} else if(isset($_POST['editProduct_button'])){
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];  
    $size = $_POST['size'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $image = $_POST['image'];
    $quantity = $_POST['quantity'];
    $meta_title = $_POST['meta_title'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1':'0'; // IF THE STATUS IS SET AND NOT NULL
    $trending = isset($_POST['trending']) ? '1':'0'; // IF THE TRENDING IS SET AND NOT NULL

    $new_image = $_FILES['image']['name']; // GET THE ORIGINAL NAME OF THE UPLOADED FILE 
    $old_image = $_POST['old_image'];

    if($new_image != ""){
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION); // GET THE FILE EXTENSION OF THE UPLOADED IMAGE 
        $update_filename = time().'.'.$image_ext; // GENERATE A UNIQUE FILENAME FOR THE UPLOADED IMAGE BY APPEDING THE CURRENT TIMESTAMP AND THE ORIGINAL FILE EXT
    } else{
        $update_filename = $old_image;
    }                                               

    $path = "../uploads";

    $update_query = "UPDATE product SET name='$name', slug='$slug', size='$size', 
    original_price='$original_price', selling_price='$selling_price', quantity='$quantity',
    meta_title='$meta_title', meta_keywords='$meta_keywords', 
    status='$status', trending='$trending', image='$update_filename' WHERE id='$product_id' ";

    $update_query_run = mysqli_query($con, $update_query);

    if($update_query_run){
        if($_FILES['image']['name'] != ""){
            move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$update_filename);
            if(file_exists("../uploads/".$old_image)){
                unlink("../uploads/".$old_image);
            }
        }
        redirect("editProduct.php?id=$product_id","Product Updated Successfully");
    } else{
        redirect("editProduct.php?id=$product_id","Something went wrong");
    }
} else if(isset($_POST['cartBtn'])){
    $productId = isset($_POST['selectedProduct']) ? $_POST['selectedProduct'] : null;
    $categoryId = isset($_POST['selectedCategory']) ? $_POST['selectedCategory'] : null;
    $quantity = isset($_POST['quantityInput']) ? $_POST['quantityInput'] : 1; // Default quantity is 1

    $userId = $_SESSION['user_id']; // Assuming 'user_id' is the session variable storing user's ID

    if(empty($productId) || empty($categoryId)){
        redirect("../order.php","Please choose a product/category!");
    } else {
        // Fetch product and category data
        $product_query = "SELECT * FROM product WHERE id = '$productId'";
        $category_query = "SELECT * FROM categories WHERE id = '$categoryId'";
        
        $product_result = mysqli_query($con, $product_query);
        $category_result = mysqli_query($con, $category_query);
        
        $product = mysqli_fetch_assoc($product_result);
        $category = mysqli_fetch_assoc($category_result);

        // Store cart item in an array
        $cartItem = array(
            'productId' => $productId,
            'productName' => $product['name'],
            'productImage' => $product['image'],
            'sellingPrice' => $product['selling_price'],
            'categoryId' => $categoryId,
            'categoryName' => $category['name'],
            'additionalPrice' => $category['additional_price'],
            'quantity' => $quantity
        );

        // Insert cart item into database table
        $insert_query = "INSERT INTO cart_items (user_id, product_id, product_name, product_image, selling_price, category_id, category_name, additional_price, quantity) 
                         VALUES ('$userId', '$productId', '{$product['name']}', '{$product['image']}', '{$product['selling_price']}', '$categoryId', '{$category['name']}', '{$category['additional_price']}', '$quantity')";
        $insert_query_run = mysqli_query($con, $insert_query);

        if($insert_query_run){
            redirect("../payment.php","Item added to cart successfully");
        }
    }
} else if(isset($_POST['deleteOrderBtn'])){
    $cart_id = mysqli_real_escape_string($con, $_POST['cart_id']);

    $cart_query = "SELECT * FROM cart_items WHERE id='$cart_id'";
    $cart_query_run = mysqli_query($con, $cart_query);
    $cart_data = mysqli_fetch_array($cart_query_run);
    $image = $cart_data['image'];

    // Delete the category
    $delete_query = "DELETE FROM cart_items WHERE id='$cart_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if($delete_query_run){
        if(file_exists("../uploads/".$image)){
            unlink("../uploads/".$image);
        }
        
        // Get the last auto-increment value
        $last_id_query = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'aquaflowdb' AND TABLE_NAME = 'cart_items'";
        $last_id_result = mysqli_query($con, $last_id_query);
        $last_id_row = mysqli_fetch_assoc($last_id_result);
        $last_auto_increment_value = $last_id_row['AUTO_INCREMENT'];

        // Set the auto-increment value to the last deleted ID
        $alter_query = "ALTER TABLE categories AUTO_INCREMENT = $cart_id";
        mysqli_query($con, $alter_query);

        redirect("../payment.php","Cart Item Deleted Successfully");
    } else{
        redirect("../payment.php","Something went wrong");
    }
}




?>