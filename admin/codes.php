<?php
session_start();
include('../config/dbconnect.php');
include('../functions/myAlerts.php');
 
if(isset($_POST['addCateg_button'])){ // IF FORM SUBMIT IS FROM addCateg_button
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $additional_price = $_POST['additional_price'];
    $status = isset($_POST['status']) ? '1':'0'; // IF THE STATUS IS SET AND NOT NULL
    
    $image = $_FILES['image']['name']; // GET THE ORIGINAL NAME OF THE UPLOADED FILE 

    $path = "../uploads"; // DEFINE THE DIRECTORY WHERE UPLOADED IMAGES IN WILL BE STORED 
    
    $image_ext = pathinfo($image, PATHINFO_EXTENSION); // GET THE FILE EXTENSION OF THE UPLOADED IMAGE 
    $filename = time().'.'.$image_ext; // GENERATE A UNIQUE FILENAME FOR THE UPLOADED IMAGE BY APPEDING THE CURRENT TIMESTAMP AND THE ORIGINAL FILE EXT
    
    $categ_query = "INSERT INTO categories
        (name,description, additional_price, status,image)
        VALUES ('$name','$description', '$additional_price', '$status','$filename')"; 
    
    $categ_query_run = mysqli_query($con, $categ_query); // EXECURE THE SQL QUERY TO INSERT CATEGORY INFORMATION INTO THE DATABASE 
    
    if($categ_query_run){
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename); // MOVE THE UPLOADED IMAGE FILE FROM THE TEMPORARY DIRECTORY TO THE SPECIFIED UPLOAD DIRECTORY WITH GENERATED FILE NAME 
        redirect("addCategory.php", "✔ Category added successfully"); 
    } else{
        redirect("addCategory.php", "Something went wrong"); 
    }
} else if(isset($_POST['editCateg_button'])){
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $additional_price = $_POST['additional_price'];
    $status = isset($_POST['status']) ? '1':'0'; // IF THE STATUS IS SET AND NOT NULL

    $new_image = $_FILES['image']['name']; // GET THE ORIGINAL NAME OF THE UPLOADED FILE 
    $old_image = $_POST['old_image'];

    if($new_image != ""){
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION); // GET THE FILE EXTENSION OF THE UPLOADED IMAGE 
        $update_filename = time().'.'.$image_ext; // GENERATE A UNIQUE FILENAME FOR THE UPLOADED IMAGE BY APPEDING THE CURRENT TIMESTAMP AND THE ORIGINAL FILE EXT
    } else{
        $update_filename = $old_image;
    }

    $path = "../uploads";

    $update_query = "UPDATE categories SET name='$name', description='$description', 
    additional_price='$additional_price', status='$status', image='$update_filename' WHERE id='$category_id' ";

    $update_query_run = mysqli_query($con, $update_query);

    if($update_query_run){
        if($_FILES['image']['name'] != ""){
            move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$update_filename);
            if(file_exists("../uploads/".$old_image)){
                unlink("../uploads/".$old_image);
            }
        }
        redirect("category.php","✔ Category Updated Successfully");
    } else{
        redirect("category.php","Something went wrong");
    }
} else if(isset($_POST['deleteCategory_button'])){
    $category_id = $_POST['category_id'];

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
        redirect("category.php","✔ Category Deleted Successfully");
    } else{
        redirect("category.php","Something went wrong");
    }
} else if(isset($_POST['addProduct_button'])){
    $name = $_POST['name'];
    $size = $_POST['size'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $image = $_POST['image'];
    $quantity = $_POST['quantity'];
    $status = isset($_POST['status']) ? '1':'0'; // IF THE STATUS IS SET AND NOT NULL
    
    $image = $_FILES['image']['name']; // GET THE ORIGINAL NAME OF THE UPLOADED FILE 

    $path = "../uploads"; // DEFINE THE DIRECTORY WHERE UPLOADED IMAGES IN WILL BE STORED 
    
    $image_ext = pathinfo($image, PATHINFO_EXTENSION); // GET THE FILE EXTENSION OF THE UPLOADED IMAGE 
    $filename = time().'.'.$image_ext; // GENERATE A UNIQUE FILENAME FOR THE UPLOADED IMAGE BY APPEDING THE CURRENT TIMESTAMP AND THE ORIGINAL FILE EXT

    $product_query = "INSERT INTO product(name, size, original_price, selling_price, quantity, status, image) 
    VALUES ('$name', '$size', '$original_price', '$selling_price', '$quantity', '$status', '$filename')";

    $product_query_run = mysqli_query($con, $product_query);

    if($product_query_run){
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename); // MOVE THE UPLOADED IMAGE FILE FROM THE TEMPORARY DIRECTORY TO THE SPECIFIED UPLOAD DIRECTORY WITH GENERATED FILE NAME 
        redirect("addProduct.php", "✔ Product added successfully"); 
    } else{
        redirect("addProduct.php", "Something went wrong"); 
    }
} else if(isset($_POST['editProduct_button'])){
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $size = $_POST['size'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $image = $_POST['image'];
    $quantity = $_POST['quantity'];
    $status = isset($_POST['status']) ? '1':'0'; // IF THE STATUS IS SET AND NOT NULL

    $new_image = $_FILES['image']['name']; // GET THE ORIGINAL NAME OF THE UPLOADED FILE 
    $old_image = $_POST['old_image'];

    if($new_image != ""){
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION); // GET THE FILE EXTENSION OF THE UPLOADED IMAGE 
        $update_filename = time().'.'.$image_ext; // GENERATE A UNIQUE FILENAME FOR THE UPLOADED IMAGE BY APPEDING THE CURRENT TIMESTAMP AND THE ORIGINAL FILE EXT
    } else{
        $update_filename = $old_image;
    }                                               

    $path = "../uploads";

    $update_query = "UPDATE product SET name='$name', size='$size', 
    original_price='$original_price', selling_price='$selling_price', quantity='$quantity',
    status='$status', image='$update_filename' WHERE id='$product_id' ";

    $update_query_run = mysqli_query($con, $update_query);

    if($update_query_run){
        if($_FILES['image']['name'] != ""){
            move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$update_filename);
            if(file_exists("../uploads/".$old_image)){
                unlink("../uploads/".$old_image);
            }
        }
        $quantity_query = "SELECT quantity FROM product WHERE id='$product_id'";
        $quantity_query_run = mysqli_query($con, $quantity_query);

        $update_query_run = mysqli_query($con, $update_query);

        if ($update_query_run) {
            // Update the status if quantity is zero
            if ($quantity == 0) {
                $status_query = "UPDATE product SET status='0' WHERE id='$product_id'";
                $status_query_run = mysqli_query($con, $status_query);
            } else {
                // Otherwise, set status to 1
                $status_query = "UPDATE product SET status='1' WHERE id='$product_id'";
                $status_query_run = mysqli_query($con, $status_query);
            }
        
            if ($_FILES['image']['name'] != "") {
                move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$update_filename);
                if (file_exists("../uploads/".$old_image)) {
                    unlink("../uploads/".$old_image);
                }
            }
            redirect("product.php","✔ Product Updated Successfully");
        } else {
            redirect("product.php","Something went wrong");
        }
    } else{
        redirect("product.php","Something went wrong");
    }
} else if(isset($_POST['deleteProduct_button'])){
    $product_id = $_POST['product_id'];

    $product_query = "SELECT * FROM product WHERE id='$product_id'";
    $product_query_run = mysqli_query($con, $product_query);
    $product_data = mysqli_fetch_array($product_query_run);
    $image = $product_data['image'];

    // Delete the category
    $delete_query = "DELETE FROM product WHERE id='$product_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if($delete_query_run){
        if(file_exists("../uploads/".$image)){
            unlink("../uploads/".$image);
        }
        redirect("product.php","✔ Product Deleted Successfully");
    } else{
        redirect("product.php","Something went wrong");
    }
} else if(isset($_POST['deleteOrder_button'])){
    $order_id = $_POST['order_id'];

    // Delete from the orders table
    $delete_order_query = "DELETE FROM orders WHERE id='$order_id'";
    $delete_order_query_run = mysqli_query($con, $delete_order_query);

    // Delete from the order_items table
    $delete_items_query = "DELETE FROM order_items WHERE order_id='$order_id'";
    $delete_items_query_run = mysqli_query($con, $delete_items_query);

    if($delete_order_query_run && $delete_items_query_run){
        redirect("orders.php","✔ Order Deleted Successfully");
    } else{
        redirect("orders.php","Something went wrong");
    }
} else if(isset($_POST['editOrderStatus'])){
    $order_id = $_POST['order_id'];
    $newStatus = $_POST['status'];

    // Initialize variables
    $insertResult = null;
    $updateProductQuantitiesResult = null;

    if ($newStatus === 'Completed'){
        $updateQuery = "UPDATE orders SET status = '$newStatus' WHERE id = '$order_id'";
        $newResult = mysqli_query($con, $updateQuery);

        // Insert necessary data into the order_transac table
        $insertQuery = "INSERT INTO order_transac (order_id, user_id, user_name, phone, address, product_id, product_name, quantity, price, total, status, subtotal, additional_fee, grand_total, order_at)
                        SELECT
                            o.id AS order_id,
                            u.user_id AS user_id,
                            u.name AS user_name,
                            u.phone AS phone,
                            u.address AS address,
                            oi.product_id AS product_id,
                            p.name AS product_name,
                            oi.quantity AS quantity,
                            p.selling_price AS price,
                            (oi.quantity * p.selling_price) AS total,
                            o.status AS status,
                            o.subtotal AS subtotal,
                            o.additional_fee AS additional_fee,
                            o.grand_total AS grand_total,
                            o.order_at AS order_at
                        FROM
                            orders o
                        INNER JOIN
                            order_items oi ON o.id = oi.order_id
                        INNER JOIN
                            users u ON o.user_id = u.user_id
                        INNER JOIN
                            product p ON oi.product_id = p.id
                        WHERE
                            o.id = '$order_id'";
        $insertResult = mysqli_query($con, $insertQuery);

        if($newResult && $insertResult){

            // Delete from the orders table
            $delete_order_query = "DELETE FROM orders WHERE id='$order_id'";
            $delete_order_query_run = mysqli_query($con, $delete_order_query);
        
            // Delete from the order_items table
            $delete_items_query = "DELETE FROM order_items WHERE order_id='$order_id'";
            $delete_items_query_run = mysqli_query($con, $delete_items_query);
        
        }

    } else if ($newStatus === 'Cancelled'){
        // Update the order status in the orders table
        $updateQuery = "UPDATE orders SET status = '$newStatus' WHERE id = '$order_id'";
        $newResult = mysqli_query($con, $updateQuery);

        // Insert necessary data into the order_transac table
        $insertQuery = "INSERT INTO order_transac (order_id, user_id, user_name, phone, address, product_id, product_name, quantity, price, total, status, subtotal, additional_fee, grand_total, order_at)
                        SELECT
                            o.id AS order_id,
                            u.user_id AS user_id,
                            u.name AS user_name,
                            u.phone AS phone,
                            u.address AS address,
                            oi.product_id AS product_id,
                            p.name AS product_name,
                            oi.quantity AS quantity,
                            p.selling_price AS price,
                            (oi.quantity * p.selling_price) AS total,
                            o.status AS status,
                            o.subtotal AS subtotal,
                            o.additional_fee AS additional_fee,
                            o.grand_total AS grand_total,
                            o.order_at AS order_at
                        FROM
                            orders o
                        INNER JOIN
                            order_items oi ON o.id = oi.order_id
                        INNER JOIN
                            users u ON o.user_id = u.user_id
                        INNER JOIN
                            product p ON oi.product_id = p.id
                        WHERE
                            o.id = '$order_id'";
        $insertResult = mysqli_query($con, $insertQuery);

        // Update product quantities in the product table
        $updateProductQuantities = "UPDATE product p
                                    INNER JOIN order_items oi ON p.id = oi.product_id
                                    SET p.quantity = p.quantity + oi.quantity
                                    WHERE oi.order_id = '$order_id'";
        $updateProductQuantitiesResult = mysqli_query($con, $updateProductQuantities);

        $updateProductStatus = "UPDATE product p
                                    INNER JOIN order_items oi ON p.id = oi.product_id
                                    SET p.status ='1'
                                    WHERE oi.order_id = '$order_id'";

        $updateProductStatusQuery = mysqli_query($con, $updateProductStatus);

        if($newResult && $insertResult &&$updateProductQuantitiesResult && $updateProductStatusQuery){

            // Delete from the orders table
            $delete_order_query = "DELETE FROM orders WHERE id='$order_id'";
            $delete_order_query_run = mysqli_query($con, $delete_order_query);
        
            // Delete from the order_items table
            $delete_items_query = "DELETE FROM order_items WHERE order_id='$order_id'";
            $delete_items_query_run = mysqli_query($con, $delete_items_query);
        
        }
    } else if($newStatus === 'Out for Delivery'){
        $updateQuery = "UPDATE orders SET status = '$newStatus' WHERE id = '$order_id'";
        $deliverResult = mysqli_query($con, $updateQuery);

    } else {
        // For any other status change, simply update the order status
        $updateQuery = "UPDATE orders SET status = '$newStatus' WHERE id = '$order_id'";
        $newResult = mysqli_query($con, $updateQuery);
    }
    
    // Check conditions based on status change
    if($newResult && $insertResult !== null && $updateProductQuantitiesResult !== null && $newStatus === 'Cancelled' && $delete_order_query_run && $delete_items_query_run){
        redirect("cancelledOrders.php", "✔ Order Cancelled"); 
    } elseif ($newResult && $insertResult !== null && $newStatus === 'Completed' && $delete_order_query_run && $delete_items_query_run) {
        redirect("completedOrders.php", "✔ Order Completed"); 
    } elseif ($newResult) {
        redirect("orders.php", "✔ Ongoing Order"); 
    } elseif ($deliverResult){
        redirect("deliverOrder.php", "✔ Order out for Delivery"); 
    } else {
        redirect("orders.php", "Something went wrong"); 
    }
} else if(isset($_POST['deleteCompleteTransacOrder_button'])){
    $order_transac_id = $_POST['order_transac_id'];

    // Delete from the orders table
    $delete_order_query = "DELETE FROM order_transac WHERE order_transac_id ='$order_transac_id'";
    $delete_order_query_run = mysqli_query($con, $delete_order_query);

    if($delete_order_query_run){
        redirect("completedOrders.php","✔ Order Transaction Deleted Successfully");
    } else{
        redirect("completedOrders.php","Something went wrong");
    }
} else if(isset($_POST['deleteCancelledTransacOrder_button'])){
    $order_transac_id = $_POST['order_transac_id'];

    // Delete from the orders table
    $delete_order_query = "DELETE FROM order_transac WHERE order_transac_id='$order_transac_id'";
    $delete_order_query_run = mysqli_query($con, $delete_order_query);

    if($delete_order_query_run){
        redirect("cancelledOrders.php","✔ Order Transaction Deleted Successfully");
    } else{
        redirect("cancelledOrders.php","Something went wrong");
    }
}


