<?php
    include('includes/header.php');
    include('includes/navbar.php');
    include('functions/userFunctions.php');
    ?>
    <link rel="stylesheet" href="assets/css/order.css">   

<section>
    <div class="container">
        <div class="order-here">
            <div class="row">
                <div class="col-md-12">
                    <h1>Order Here!</h1>
                </div>
            </div>
        </div>
        <!--------------- PRODUCTS --------------->
        <div class="sizes" id="sizes">
            <h3 id="sizehead" style="font-weight: bold; font-family: 'Poppins', sans-serif;">Products</h3>
            <hr>
        </div>
        <?php
            $product = getAllActive("product");

            if(mysqli_num_rows($product) > 0):
            ?>
                <!-- Start of row -->
                <div class="row">
                    <?php foreach($product as $item): ?>
                        <!-- Start of column -->
                        <div class="col-md-3">
                            <div class="card" style="border: none;">
                                <img src="uploads/<?= $item['image']; ?>" class="card-img-top" alt="Product Image" class="w-50" 
                                style="height: 200px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.9);">
                                <div class="card-body" style="border: none;">
                                    <br>
                                    <h6 class="card-title text-center" style="font-size: 18px; font-family: 'Poppins', sans-serif;
                                    font-weight: bold;">₱ <?= $item['selling_price']; ?>.00</h6>
                                    <h5 class="card-title text-center" style="font-size: 22px;
                                    font-family: 'Poppins', sans-serif; font-weight: bold;"><?= $item['name']; ?></h5>
                                    <h6 class="card-title text-center" style="font-size: 16px; font-family: 'Poppins', sans-serif;
                                    color: #013D67;"><?= $item['size']; ?></h6>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php
            endif;
            ?>

        <!--------------- CATEGORIES --------------->
        <div class="category" id="categ">
            <h3 id="categoryheader" style="font-weight: bold; font-family: 'Poppins', sans-serif;"> Categories </h3>
            <hr>
        </div>
        <!--------------- TO SHOW CATEGORY DATA --------------->
<?php 
    $categories = getAllActive("categories"); // GET ALL ACTIVE CATEGORIES
    $colors = array('#DDEFF5', '#CBE6EF', '#A9D6E5'); // DEFINE ARRAY OF COLORS FOR CATGORY CARDS
    $color_count = count($colors); // GET THE TOTAL NUMBER OF COLORS

    if(mysqli_num_rows($categories) > 0){ // CHECK IF THERE ARE CATEGORIES
        $i = 0; // INITIALIZE COUNTER VARIABLE FOR KNOW INDECES OF COLORS
        foreach($categories as $item){
            $current_color = $colors[$i % $color_count]; // GET CURRENT COLOR FRROM ARRAY COLOR
?>
    <!--------------- CATEGORY CARD --------------->
            <div class="card mb-3" style="max-width: 80rem; border-radius: 10px; background-color: <?= $current_color; ?>">
                <div class="row g-0">
                    <div class="col-md-2">
                        <div style="height: 100%;">
                            <!--------------- CATEGORY IMAGE --------------->
                            <img src="uploads/<?= $item['image']; ?>" alt="Category image" class="w-100" style="height: 150px; border-radius: 10px;">
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="card-body">
                            <!--------------- CATEGORY TITLE --------------->
                            <h4 class="text-left" id="category-card-title-header" style="font-weight: bold; font-family: 'Poppins', sans-serif;">
                                <?= $item['name']; ?> 
                                <span style="color: #013D67; font-weight: lighter; font-size: 21px; float: right;">Add ₱<?= $item['additional_price']; ?>.00</span>
                            </h4>
                            <!--------------- CATEGORY DESCRIPTION --------------->
                            <p id="category-card-texxt-header" style="font-family: 'Poppins', sans-serif;"><?= $item['description']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
<?php
            $i++; // INCREMENT THE COUNTER VARIABLE TO MOVE TO NEXT COLOR
        }
    } else{
        echo "No data available"; // IF NO CATEGORY AVAILABLE
    }
?>

    <!--------------- QUANTITY --------------->
    <div class="card text mb-3" id="quantitybox"  style="max-width: 80rem;">
        <div class="addqty">
            <div class="row align-items-center" >
                <div class="col-lg-8" id="textqty">
                    <h2 style="display: inline;">Quantity</h2>
                </div>
                <div class="col-lg-2 text-right" id="qty">
                    <div class="qty mt-1">
                        <span class="minus bg-dark">-</span>
                        <input type="number" class="count" name="qty" value="1">
                        <span class="plus bg-dark">+</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--------------- SUBMIT BUTTON --------------->
    <div class="submitbtn">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-md btn-block" id="submit" style="background-color: #013D67; color: #fff;">
                    Submit
                </button>
            </div>
        </div>
    </div>
</section>

<script src="order.js"></script>

 <!--------------- FOOTER --------------->
 <?php include('includes/footer.php');?>