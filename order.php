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
        <div class="sizes" id="sizes">
            <h3 id="sizehead ">Sizes</h3>
            <hr>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class=" row justify-content-center " id="gallons">
                        <div class="col-md-2" id="images" style="text-align: center;">
                            <img alt="Water Bottle" class="img-fluid" src="assets/images/bottle.png" />
                            <div class="description">
                                <h3 id="price">₱10.00</h3>
                                <div class="text-center"> 
                                    <blockquote class="blockquote">
                                        <p class="mb-3" id="desc">Bottled Water</p>
                                        <footer class="blockquote-footer">350ml</footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2" id="images" style="text-align: center;">
                            <img alt="Water Bottle" class="img-fluid" src="assets/images/1LBottle.png" />
                            <div class="description">
                                <h3 id="price">₱15.00</h3>
                                <div class="text-center"> 
                                    <blockquote class="blockquote">
                                        <p class="mb-3" id="desc">Bottled Water</p>
                                        <footer class="blockquote-footer">1liter</footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2" id="images" style="text-align: center;">
                            <img alt="Water Bottle" class="img-fluid" src="assets/images/slim container.png" />
                            <div class="description">
                                <h3 id="price">₱25.00</h3>
                                <div class="text-center"> 
                                    <blockquote class="blockquote">
                                        <p class="mb-3" id="desc">Slim Container</p>
                                        <footer class="blockquote-footer">2.50gal</footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2" id="images" style="text-align: center;">
                            <img alt="Water Bottle" class="img-fluid" src="assets/images/5gal.png" />
                            <div class="description">
                                <h3 id="price">₱35.00</h3>
                                <div class="text-center"> 
                                    <blockquote class="blockquote">
                                        <p class="mb-3" id="desc">Slim Container</p>
                                        <footer class="blockquote-footer">5.00gal</footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2" id="images" style="text-align: center;">
                            <img alt="Water Bottle" class="img-fluid" src="assets/images/round.png" />
                            <div class="description">
                                <h3 id="price">₱50.00</h3>
                                <div class="text-center"> 
                                    <blockquote class="blockquote">
                                        <p class="mb-3" id="desc">Round Container</p>
                                        <footer class="blockquote-footer">5.00gal</footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--------------- CATEGORIES --------------->
        <div class="category" id="categ">
            <h3 id="categoryheader "> Categories </h3>
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