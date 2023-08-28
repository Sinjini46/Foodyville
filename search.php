<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php"); // connection to db
error_reporting(0);
session_start();
include_once 'product-action.php'; //including controller
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="potoffood.png">
    <title>Dishes</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!--header starts-->
    <header id="header" class="header-scroll top-header headrom">
        <!-- .navbar -->
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" id="animateText" href="index.php"> FOODYVILLE </a>
                <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants <span class="sr-only"></span></a> </li>
                        <?php
                        if (empty($_SESSION["user_id"])) {
                            echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
                                <li class="nav-item"><a href="registration.php" class="nav-link active">Sign Up</a> </li>';
                        } else {
                            echo  '<li class="nav-item"><a href="your_orders.php" class="nav-link active">Your Orders</a> </li>';
                            echo  '<li class="nav-item"><a href="logout.php" class="nav-link active">LogOut</a> </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- /.navbar -->
    </header>
    <div class="breadcrumb">
        <div class="container"></div>
    </div>
    <div class="container m-t-30">
        <div class="row">
            <h2>search results for <?php echo $_GET['search'] ?></h2>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                <!-- end:Widget menu -->
                <div class="menu-widget" id="2">
                    <div class="widget-heading">
                        <h3 class="widget-title text-dark">
                            Your Menu <a class="btn btn-link pull-right" data-toggle="collapse" href="#popular2" aria-expanded="true">
                                <i class="fa fa-angle-right pull-right"></i>
                                <i class="fa fa-angle-down pull-right"></i>
                            </a>
                        </h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="collapse in" id="popular2">
                        <?php  // display values and item of food/dishes
                        $noresults = true;
                        $query = $_GET['search'];
                        $sql = "SELECT * FROM dishes WHERE MATCH(title,slogan) AGAINST ('$query')";
                        $result = mysqli_query($db, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $title = $row['title'];
                            $desc = $row['slogan'];
                            $dish_id = $row['rs_id'];
                            $price = $row['price'];
                            $url = "dishes.php?res_id=" . $dish_id;
                            $noresults = false;
                        ?>
                            <div class="food-item">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-lg-8">
                                        <form method="post" action='dishes.php?res_id=<?php echo $dish_id; ?>&action=add&id=<?php echo $row['d_id']; ?>'>
                                            <div class="rest-logo pull-left">
                                                <a class="restaurant-logo pull-left" href="#"><?php echo '<img src="admin/Res_img/dishes/' . $row['img'] . '" alt="Food logo">'; ?></a>
                                            </div>
                                            <!-- end:Logo -->
                                            <div class="rest-descr">
                                                <h6><a href="#"><?php echo $title; ?></a></h6>
                                                <p> <?php echo $slogan; ?></p>
                                            </div>
                                            <!-- end:Description -->
                                    </div>
                                    <!-- end:col -->
                                    <div class="col-xs-12 col-sm-12 col-lg-4 pull-right item-cart-info">
                                        <span class="price pull-left">&#8377;<?php echo $price; ?></span>
                                        <input class="b-r-0" type="text" name="quantity" style="margin-left:30px" value="1" size="2" />
                                        <input type="submit" class="btn theme-btn" style="margin-left:40px;" value="Add to cart" />
                                    </div>
                                    </form>
                                </div>
                                <!-- end:row -->
                            </div>
                            <!-- end:Food item -->
                        <?php
                        }
                        if ($noresults) {
                            echo '<div class="jumbotron jumbotron-fluid">
                                            <div class="container">
                                                <p class="display-4">No Results Found</p>
                                                <p class="lead"> Suggestions: <ul>
                                                        <li>Make sure that all words are spelled correctly.</li>
                                                        <li>Try different keywords.</li>
                                                        <li>Try more general keywords. </li></ul>
                                                </p>
                                            </div>
                                         </div>';
                        }
                        ?>
                    </div>
                    <!-- end:Collapse -->
                </div>
                <!-- end:Widget menu -->
            </div>
            <!-- end:Bar -->
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                <div class="widget widget-cart">
                    <div class="widget-heading">
                        <h3 class="widget-title text-dark">Your Shopping Cart</h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="order-row bg-white">
                        <div class="widget-body">
                            <?php
                            $item_total = 0;
                            foreach ($_SESSION["cart_item"] as $item)  // fetch items define current into session ID
                            {
                            ?>
                                <div class="title-row">
                                    <?php echo $item["title"]; ?><a href="dishes.php?res_id=<?php echo $_GET['res_id']; ?>&action=remove&id=<?php echo $item["d_id"]; ?>">
                                        <i class="fa fa-trash pull-right"></i></a>
                                </div>
                                <div class="form-group row no-gutter">
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control b-r-0" value=<?php echo $item["price"]; ?> readonly id="exampleSelect1">
                                    </div>
                                    <div class="col-xs-4">
                                        <input class="form-control" type="text" readonly value='<?php echo $item["quantity"]; ?>' id="example-number-input">
                                    </div>
                                </div>
                            <?php
                                $item_total += ($item["price"] * $item["quantity"]); // calculating current price into cart
                            }
                            ?>
                        </div>
                    </div>
                    <!-- end:Order row -->
                    <div class="widget-body">
                        <div class="price-wrap text-xs-center">
                            <p>Total Amount</p>
                            <h3 class="value"><strong>&#8377;<?php echo $item_total; ?></strong></h3>
                            <p>Free Shipping</p>
                            <a href="checkout.php?res_id=<?php echo $_GET['res_id']; ?>&action=check" class="btn theme-btn btn-lg">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:row -->
    </div>
    <!-- end:Container -->
    <section class="app-section">
        <div class="app-wrap">
            <div class="container">
                <div class="row text-img-block text-xs-left">
                    <div class="container">
                        <div class="col-xs-12 col-sm-5 right-image text-center">
                            <figure> <img src="images/app.png" alt="Right Image" class="img-fluid"> </figure>
                        </div>
                        <div class="col-xs-12 col-sm-7 left-text">
                            <h3>Foodyville - Your hunger, our priority.</h3>
                            <p>Got Hungry?Order what you like, from the restaurants you love, delivered at blinking speed.
                                Browse a diverse range of restaurants, discover local flavors, and enjoy your favorite dishes delivered to your doorstep with a tap of a button.</p>
                            <div class="social-btns">
                                <a href="#" class="app-btn apple-button clearfix">
                                    <div class="pull-left"><i class="fa fa-apple"></i> </div>
                                    <div class="pull-right"> <span class="text">Available on the</span> <span class="text-2">App Store</span> </div>
                                </a>
                                <a href="#" class="app-btn android-button clearfix">
                                    <div class="pull-left"><i class="fa fa-android"></i> </div>
                                    <div class="pull-right"> <span class="text">Available on the</span> <span class="text-2">Play Store</span> </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- start: FOOTER -->
    <footer class="footer">
        <div class="container">
            <!-- top footer statrs -->
            <div class="row top-footer">
                <div class="col-xs-12 col-sm-3 footer-logo-block color-gray">
                    <a href="#"> <img src="images/foodyville.png" alt="Footer logo"> </a> <span>Delivered with love! </span>
                </div>
                <div class="col-xs-12 col-sm-2 about color-gray">
                    <h5>About Us</h5>
                    <ul>
                        <li><a href="#about">Our Mission</a></li>
                        <li><a href="#">Social Media</a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-2 how-it-works-links color-gray">
                    <h5>How it Works?</h5>
                    <ul>
                        <li><a href="#">Choose the restaurant</a></li>
                        <li><a href="#">Choose your dishes</a></li>
                        <li><a href="#">Choose Your payment</a></li>
                        <li><a href="#">Get delivered</a></li>
                        <li><a href="#">Enjoy your meals :)</a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-2 pages color-gray">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="#">Terms & Conditions</a> </li>
                        <li><a href="#">Refund & Cancellation</a> </li>
                        <li><a href="#">Privacy Policy</a> </li>
                        <li><a href="#">Cookie Policy</a> </li>
                        <li><a href="#">Offer Terms</a> </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-3 popular-locations color-gray">
                    <h5>Locations We Deliver To</h5>
                    <ul>
                        <li><a href="#">Salt Lake City</a> </li>
                        <li><a href="#">New Town</a> </li>
                        <li><a href="#">Ballygunge</a> </li>
                        <li><a href="#">Jadavpur</a> </li>
                        <li><a href="#">Tollygunge</a> </li>
                        <li><a href="#">Chinar Park</a> </li>
                        <li><a href="#">Howrah</a> </li>
                        <li><a href="#">Behala</a> </li>
                        <li><a href="#">Garia</a> </li>
                        <li><a href="#">Park Street</a> </li>
                    </ul>
                </div>
            </div>
            <!-- top footer ends -->
            <!-- bottom footer statrs -->
            <center>
                <div class="bottom-footer">
                    <div class="row">
                        <div class="col-xs-6 payment-options color-gray">
                            <h5>All Major Credit Cards Accepted</h5>
                            <ul>
                                <li>
                                    <a href="#"> <img src="images/paypal.png" alt="Paypal"> </a>
                                </li>
                                <li>
                                    <a href="#"> <img src="images/mastercard.png" alt="Mastercard"> </a>
                                </li>
                                <li>
                                    <a href="#"> <img src="images/maestro.png" alt="Maestro"> </a>
                                </li>
                                <li>
                                    <a href="#"> <img src="images/stripe.png" alt="Stripe"> </a>
                                </li>
                                <li>
                                    <a href="#"> <img src="images/bitcoin.png" alt="Bitcoin"> </a>
                                </li>
                            </ul>
                            <p class="pay-info">Pay by Cash on delivery or Card Payment</p>
                        </div>
                        <div class="col-xs-12 col-sm-4 address color-gray">
                            <h5>Address:</h5>
                            <p>saltlake,kolkata-700091.</p>
                            <h5>Call us at: <a href="tel:+914450005500">+91 7418529630</a></h5>
                        </div>
                    </div>
                    <strong style="color:white"> &copy; Copyright FoodyVille</span>. All Rights Reserved</strong>
                </div>
                <!-- bottom footer ends -->
        </div>
    </footer>
    </center>
    <!-- end:Footer -->
    </div>
    <!-- end:page wrapper -->
    </div>
    <!--/end:Site wrapper -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
</body>
</html>