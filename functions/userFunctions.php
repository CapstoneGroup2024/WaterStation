<?php
    include('config/dbconnect.php');

    // FUNCTION TO GET ALL ACTIVE RECORDS FROM A SPECIFIED TABLE
    function getAllActive($table){ 
        global $con; 
        $query = "SELECT * FROM $table WHERE status='1' "; 
        return $query_run = mysqli_query($con, $query); 
    }

    // FUNCTION TO GET CART ITEMS BY USER ID
    function getCartItemsByUserId($userId) {
        global $con; 
    
        // QUERY TO SELECT CART ITEMS FOR A SPECIFIC USER
        $query = "SELECT * FROM cart_items WHERE user_id = '$userId'";
        $result = mysqli_query($con, $query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            return $result; // Return the result set
        } else {
            // DISPLAY ERROR MESSAGE IF QUERY FAILED
            echo "Error retrieving cart items: " . mysqli_error($con);
            return false;
        }
    }
    

    // FUNCTION TO GET RECORD BY ID FROM A SPECIFIED TABLE
    function getByID($table, $id){ 
        global $con; 
        $query = "SELECT * FROM $table WHERE id='$id'"; 
        $result = mysqli_query($con, $query); 

        if ($result) {
            // CHECK IF THERE ARE RESULTS
            if(mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            } else {
                // DISPLAY MESSAGE IF NO RECORDS FOUND
                echo "No records found for ID: $id";
                return false;
            }
        } else {
            // DISPLAY ERROR MESSAGE IF QUERY FAILED
            echo "Error executing query: " . mysqli_error($con);
            return false;
        }
    }

    // FUNCTION TO GET ORDER ITEMS BY USER I

    function getActiveCartItemsByUserId($userId, $con) {
        $query = "SELECT ci.*, p.id AS product_id, p.name AS product_name, c.id AS category_id, c.name AS category_name 
                  FROM cart_items ci
                  LEFT JOIN product p ON ci.id = p.id
                  LEFT JOIN categories c ON p.id = c.id
                  WHERE ci.user_id = ?";
        $statement = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($statement, "s", $userId);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        if ($result) {
            return $result; 
        } else {
            error_log("Error retrieving cart items: " . mysqli_error($con));
            return false;
        }
    }
    
    function isProductActive($productId, $categoryId, $con) {
        $product_query = "SELECT * FROM product WHERE id = ? LIMIT 1";
        $category_query = "SELECT * FROM categories WHERE id = ? LIMIT 1";
        
        $stmt_product = mysqli_prepare($con, $product_query);
        $stmt_category = mysqli_prepare($con, $category_query);
        
        mysqli_stmt_bind_param($stmt_product, "i", $productId);
        mysqli_stmt_bind_param($stmt_category, "i", $categoryId);
        
        mysqli_stmt_execute($stmt_product);
        $product_result = mysqli_stmt_get_result($stmt_product);
        $productIsActive = mysqli_num_rows($product_result) > 0;
        
        mysqli_stmt_execute($stmt_category);
        $category_result = mysqli_stmt_get_result($stmt_category);
        $categoryIsActive = mysqli_num_rows($category_result) > 0;
        
        mysqli_stmt_close($stmt_product);
        mysqli_stmt_close($stmt_category);
        
        return $productIsActive && $categoryIsActive;
    }

// Function to fetch products based on order ID from the database
function getProductsByOrderId($order_id) {
    global $con;
    // Initialize an empty array to store products
    $products = array();

    // Prepare and execute the SQL query to fetch products based on order ID
    $query = "SELECT * FROM order_items WHERE order_id = ?";
    $statement = $con->prepare($query);
    $statement->bind_param("i", $order_id);
    $statement->execute();
    $result = $statement->get_result();

    // Fetch products and add them to the products array
    while ($row = $result->fetch_assoc()) {
        // Assuming you have a products table where you can retrieve product details based on product ID
        $product_id = $row['product_id'];
        $product_query = "SELECT * FROM product WHERE id = ?";
        $product_statement = $con->prepare($product_query);
        $product_statement->bind_param("i", $product_id);
        $product_statement->execute();
        $product_result = $product_statement->get_result();
        $product = $product_result->fetch_assoc();

        // Add product details to the products array
        $products[] = array(
            'product_id' => $product['id'],
            'product_name' => $product['name'],
            'quantity' => $row['quantity'],
            'price' => $row['price']
        );
    }

    // Close the statement and database connection
    $statement->close();
    $con->close();

    // Return the array of products
    return $products;
}


function getAllActiveProducts($con) { 
    $query = "SELECT * FROM product WHERE status='1'"; 
    return mysqli_query($con, $query); 
}

// Function to update product status to unavailable
function updateProductStatus($productId, $con) {

    global $con;
    $query = "UPDATE product SET status = '0' WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->close();
}

// Get all active products