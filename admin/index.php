<?php 
    include('includes/header.php');
    include('../middleware/adminMid.php');
    include('dashboard.php');
?>

<div class="container">
    <div class="row">
        <div class="col-lg-8 position-relative z-index-2">
            <div class="card card-plain mb-4">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-lg-8">
                                <h2 class="font-weight-bolder mb-0">General Statistics</h2>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card mb-2">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">weekend</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Delivery Today</p>
                            <h4 class="mb-0"><?php echo number_format($totalDeliverToday); ?></h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="<?php echo $changeClass; ?> text-sm font-weight-bolder"><?php echo $changeText; ?></span></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card mb-2">
                    <div class="card-header p-3 pt-2 bg-transparent">
                        <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">leaderboard</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Pending Orders</p>
                            <h4 class="mb-0"><?php echo number_format($totalOngoingOrders); ?></h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="<?php echo ($percentageChange >= 0) ? 'text-success' : 'text-danger'; ?> text-sm font-weight-bolder"><?php echo $changeTxt; ?><span style="color: black;"> compared 5 hours ago</span></span></p>
                    </div>
                </div>
            </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card mb-2">
                        <div class="card-header p-3 pt-2 bg-transparent">
                            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">store</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Today's Profit</p>
                                <h4 class="mb-0">₱ <?php echo number_format($todayRevenue); ?></h4>
                            </div>
                        </div>
                        <hr class="horizontal my-0 dark">
                        <div class="card-footer p-3">
                            <?php
                            // Calculate percentage change
                            if ($yesterdayRevenue != 0) {
                                $percentageChange = (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100;
                                $changeClass = ($percentageChange > 0) ? 'text-success' : 'text-danger';
                                $changeSymbol = ($percentageChange > 0) ? '+' : '';
                                $changeText = sprintf('%s%.2f%% than yesterday', $changeSymbol, abs($percentageChange));
                            } else {
                                $changeText = 'No data for yesterday';
                                $changeClass = 'text-muted';
                            }
                            ?>
                            <p class="mb-0"><span class="<?php echo $changeClass; ?> text-sm font-weight-bolder"><?php echo $changeText; ?></span></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card mb-2">
                        <div class="card-header p-3 pt-2 bg-transparent">
                            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">person_add</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize ">Users</p>
                                <h4 class="mb-0 "><?php echo number_format($totalUsers); ?></h4>
                            </div>
                        </div>
                        <hr class="horizontal my-0 dark">
                        <div class="card-footer p-3">
                            <?php
                            // Example of dynamic message based on recent additions
                            if ($newUsersCount > 0) {
                                echo "<p class='mb-0'>Just updated with new users!</p>";
                            } else {
                                echo "<p class='mb-0'>Just updated</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="dashboard_div">
                <!--Divs that will hold each control and chart-->
                <div id="filter_div">ffd</div>
                <div id="chart_div">fdfdfd</div>
            </div>
        </div>
    </div>
</div>
<!--------------- ALERTIFY JS --------------->
<?php include('includes/footer.php');?>
