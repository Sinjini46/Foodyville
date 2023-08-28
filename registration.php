<!DOCTYPE html>
<html lang="en">
<?php
if( empty(session_id()) && !headers_sent()){
    session_start();
}
error_reporting(0); // hide undefine index
include("connection/connect.php"); // connection
if (isset($_POST['submit'])) //if submit btn is pressed
{
    if (
        empty($_POST['firstname']) ||  //fetching and find if its empty
        empty($_POST['lastname']) ||
        empty($_POST['email']) ||
        empty($_POST['phone']) ||
        empty($_POST['password']) ||
        empty($_POST['cpassword']) ||
        empty($_POST['cpassword'])
    ) {
        $message = "All fields must be Required!";
    } else {
        //cheching username & email if already present
        $check_username = mysqli_query($db, "SELECT username FROM users where username = '" . $_POST['username'] . "' ");
        $check_email = mysqli_query($db, "SELECT email FROM users where email = '" . $_POST['email'] . "' ");
        if ($_POST['password'] != $_POST['cpassword']) {  //matching passwords
            $message = "Password not match";
        } elseif (strlen($_POST['password']) < 6)  //cal password length
        {
            $message = "Password Must be >=6";
        } elseif (strlen($_POST['phone']) < 10)  //cal phone length
        {
            $message = "invalid phone number!";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) // Validate email address
        {
            $message = "Invalid email address please type a valid email!";
        } elseif (mysqli_num_rows($check_username) > 0)  //check username
        {
            $message = 'username Already exists!';
        } elseif (mysqli_num_rows($check_email) > 0) //check email
        {
            $message = 'Email Already exists!';
        } else {
            //inserting values into db
            $mql = "INSERT INTO users(username,f_name,l_name,email,phone,password,address) VALUES('" . $_POST['username'] . "','" . $_POST['firstname'] . "','" . $_POST['lastname'] . "','" . $_POST['email'] . "','" . $_POST['phone'] . "','" . md5($_POST['password']) . "','" . $_POST['address'] . "')";
            mysqli_query($db, $mql);
            $success = "<div class='alert alert-success' role='alert'>Account Created successfully! You will be redirected in <span id='counter'>5</span> second(s).</div>
			<script type='text/javascript'>
			    function countdown() {
				    var i = document.getElementById('counter');
						if (parseInt(i.innerHTML)<=0) {
							location.href = 'login.php';
						}
						i.innerHTML = parseInt(i.innerHTML)-1;
				}
				setInterval(function(){ countdown(); },1000);
			</script>'";
            header("refresh:5;url=login.php"); // redireted once inserted success
        }
    }
}
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Registration</title>
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
                <a class="navbar-brand" id="animateText" href="index.php"> FOODYVILLE</a>
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
    <div class="registration-wrapper" >
        <div class="breadcrumb" >
            <div class="container" >
                <ul>
                    <li><a href="#" class="active">
                            <span style="color:red;"><?php echo $message; ?></span>
                            <span style="color:green;">
                                <?php echo $success; ?>
                            </span>
                        </a></li>
                </ul>
            </div>
        </div>
        </div>
        <section class="contact-page inner-page">
            <div class="container">
            <h4>Taste the Convenience,<strong>Register with FoodyVille!</strong> </h4>
                <div class="row">
                    <!-- REGISTER -->
                    <div class="col-md-8">
                        <div class="widget" >
                            <div class="widget-body">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="exampleInputEmail1">User Name</label>
                                            <input class="form-control" type="text" name="username" id="example-text-input" placeholder="UserName">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">First Name</label>
                                            <input class="form-control" type="text" name="firstname" id="example-text-input" placeholder="First Name">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Last Name</label>
                                            <input class="form-control" type="text" name="lastname" id="example-text-input-2" placeholder="Last Name">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="text" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email"> <small id="emailHelp" class="form-text text-muted">We"ll never share your email with anyone else.</small>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Phone number</label>
                                            <input class="form-control" type="text" name="phone" id="example-tel-input-3" placeholder="Phone"> <small class="form-text text-muted">We"ll never share your email with anyone else.</small>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputPassword1">Repeat password</label>
                                            <input type="password" class="form-control" name="cpassword" id="exampleInputPassword2" placeholder="Password">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="exampleTextarea">Delivery Address</label>
                                            <textarea class="form-control" id="exampleTextarea" name="address" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p> <input type="submit" value="Register" name="submit" class="btn theme-btn"> </p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- end: Widget -->
                        </div>
                        <!-- /REGISTER -->
                    </div>
                    <!-- WHY? -->
                    <div class="col-md-4">
                       <p>Register now to access a seamless food ordering experience.</p>
                       <p>With a simple registration process, you can indulge in your favorite dishes from beloved restaurants, track orders in real-time, and enjoy secure and convenient payment options. Join FoodyVille today and embark on a culinary journey like no other!</p>
                        <hr>
                        <img src="./images/img/main.jpeg" alt="" class="img-fluid">
                        <p><strong> Frequently Asked Questions(FAQ)</strong></p>
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a data-parent="#accordion" data-toggle="collapse" class="panel-toggle collapsed" href="#faq1" aria-expanded="false"><i class="ti-info-alt" aria-hidden="true"></i>How can I place an order on FoodyVille?</a></h4>
                            </div>
                            <div class="panel-collapse collapse" id="faq1" aria-expanded="false" role="article" style="height: 0px;">
                                <div class="panel-body">To place an order, simply visit FoodyVille's website,login into your account ,browse the available restaurants and their menus, customize your meal,add to cart and proceed to checkout.</div>
                            </div>
                        </div>
                        <!-- end:panel -->
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a data-parent="#accordion" data-toggle="collapse" class="panel-toggle" href="#faq2" aria-expanded="true"><i class="ti-info-alt" aria-hidden="true"></i>What payment methods does FoodyVille accept?</a></h4>
                            </div>
                            <div class="panel-collapse collapse" id="faq2" aria-expanded="true" role="article">
                                <div class="panel-body">FoodyVille accepts various payment options, including credit/debit cards, mobile wallets, and cash on delivery, ensuring a secure and convenient checkout process.</div>
                            </div>
                        </div>
                        <!-- end:Panel -->
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a data-parent="#accordion" data-toggle="collapse" class="panel-toggle" href="#faq2" aria-expanded="true"><i class="ti-info-alt" aria-hidden="true"></i>Do you charge for delivery?</a></h4>
                            </div>
                            <div class="panel-collapse collapse" id="faq2" aria-expanded="true" role="article">
                                <div class="panel-body">Delivery fee varies from city to city and is applicable if order value is below a certain amount. Additionally, certain restaurants might have fixed delivery fees. Delivery fee (if any) is specified on the 'Review Order' page.</div>
                            </div>
                        </div>
                        <!-- end:Panel -->
                        <h4 class="m-t-20">Contact Customer Support</h4>
                        <p> Feel free to reach out to our customer support if you have any further questions or inquiries. Happy ordering with FoodyVille!</p>
                        <p> <a href="#footer" class="btn theme-btn m-t-15">Contact Us</a> </p>
                    </div>
                    <!-- /WHY? -->
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
    <footer class="footer" id="footer">
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
                    <strong  style="color:white"> &copy; Copyright FoodyVille</span>. All Rights Reserved</strong>
            </div>
            <!-- bottom footer ends -->
        </div>
    </footer>
    </center>
    <!-- end:Footer -->
    </div>
    <!-- end:page wrapper -->
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