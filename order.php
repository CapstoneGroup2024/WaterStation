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
            <h3 id="sizehead ">Products</h3>
            <hr>
        </div>
        <?php
            $product = getAllActive("product");

            if(mysqli_num_rows($product) > 0){
                foreach($product as $item){
        ?>
            <!--------------- PRODUCT CARD --------------->
            <div class="card" style="width: 18rem;">
                <img src="uploads/<?= $item['image']; ?>" class="card-img-top" alt="Product Image">
                <div class="card-body">
                    <br>
                    <h6>₱ <?= $item['selling_price']; ?>.00</h6>
                    <h5 class="card-title"><?= $item['name']; ?></h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">An item</li>
                    <li class="list-group-item">A second item</li>
                    <li class="list-group-item">A third item</li>
                </ul>
                <div class="card-body">
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div>
            <?php
                }
            }

        ?>
        <!--------------- CATEGORIES --------------->
        <div class="category" id="categ">
            <h3 id="categoryheader"> Categories </h3>
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
                            <h4 class="text-left" id="category-card-title-header"><?= $item['name']; ?></h4>
                            <!--------------- CATEGORY DESCRIPTION --------------->
                            <p id="category-card-texxt-header"><?= $item['description']; ?></p>
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