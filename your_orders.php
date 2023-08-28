<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();
if (empty($_SESSION['user_id']))  //if usser is not login redirected back to login page
{
    header('location:login.php');
} else {
?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="ecommerce.png">
        <title>Your Orders</title>
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
                    <a class="navbar-brand" id="animateText" href="index.php"> FOODVILLE </a>
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
        <div class="page-wrapper">
            <!-- top Links -->
            <!-- end:Top links -->
            <!-- start: Inner page hero -->
            <div class="inner-page-hero bg-image" data-image-src="images/img/res.jpeg">
                <div class="container"> </div>
                <!-- end:Container -->
            </div>
            <div class="result-show">
                <div class="container">
                    <center> <h4><strong>Your Orders with FoodyVille!</strong> </h4> </center>
                    <div class="row">
                    </div>
                </div>
            </div>
            <!-- //results show -->
            <section class="restaurants-page">
                <div class="container">
                    <div class="col-xs-12 ">
                        <div class="row">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // displaying current session user login orders
                                    $query_res = mysqli_query($db, "select * from users_orders where u_id='" . $_SESSION['user_id'] . "'");
                                    if (!mysqli_num_rows($query_res) > 0) {
                                        echo '<td colspan="6"><center>You have No orders Placed yet. </center></td>';
                                    } else {
                                        while ($row = mysqli_fetch_array($query_res)) {
                                    ?>
                                            <tr>
                                                <td data-column="Item"> <?php echo $row['title']; ?></td>
                                                <td data-column="Quantity"> <?php echo $row['quantity']; ?></td>
                                                <td data-column="Price">&#8377; <?php echo $row['price']; ?></td>
                                                <td data-column="Status">
                                                    <?php
                                                    $status = $row['status'];
                                                    if ($status == "" or $status == "NULL") {
                                                    ?>
                                                        <p  class="status" style="font-weight:bold;">Dispatch</p>
                                                    <?php
                                                    }
                                                    if ($status == "in process") { ?>
                                                        <p  class="status" style="font-weight:bold;">On the Way!</p>
                                                    <?php
                                                    }
                                                    if ($status == "closed") {
                                                    ?>
                                                         <p  class="status" style="font-weight:bold;">Delivered</p>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($status == "rejected") {
                                                    ?>
                                                        <p  class="status" style="font-weight:bold;"><i class="fa fa-close"></i>Cancelled</p>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td data-column="Date"> <?php echo $row['date']; ?></td>
                                                <td data-column="Action"> <a href="delete_orders.php?order_del=<?php echo $row['o_id']; ?>" onclick="return confirm('Are you sure you want to cancel your order?');" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o" style="font-size:16px"></i></a>
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <!--end:row -->
                    </div>
                </div>
        </div>
        </div>
        </section>
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
<?php
}
?>