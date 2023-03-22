<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css">
    <title>Home Page</title>
</head>

<body>
    <nav class="main-nav">
        <div class="logo">Canoy Bike Shop</div>
        <div class="nav-items">
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Shop</a></li>
            <li><a href="contacts.php">Contacts</a></li>
            <li><a href="about.php">About</a></li>
        </div>
        <div class="cart-icon">
            <a href="cart.php">
                <?php
                if (isset($_SESSION["usersId"])) {
                    $select_rows = mysqli_query($con, "SELECT * FROM `cart` WHERE usersId=$user_data[usersId]") or die('query failed');
                    $row_count = mysqli_num_rows($select_rows);
                    echo '<i class="fas fa-shopping-cart"><span>' . $row_count . ' </span></i>';
                } else {
                    echo '<i class="fas fa-shopping-cart"></i>';
                }
                ?>
            </a>
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background:#630000; color:#fff; font-size:18px;">Profile</button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <?php
                    if (isset($_SESSION["usersId"])) {
                        echo "<li><a class='dropdown-item' href='profile.php?usersId=$user_data[usersId]' style='color:black; font-size:15px;'> $user_data[usersName]  </a></li>";
                        echo "<li><a class='dropdown-item' href='logout.php' style='color:black; font-size:15px;'>Logout</a></li>";
                    } else {
                        echo "<li><a class='dropdown-item' href='login.php' style='color:black; font-size:15px;'>Login</a></li>";
                        echo "<li><a class='dropdown-item' href='register.php' style='color:black; font-size:15px;'>Register</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <div class="bg-wrap">
            <div class="demo-content">
                <div class="content-about">
                    <header class="space">About Us</header>
                </div>
                <div class="shop-content">
                    <div class="shop-desc">
                        <h2>Canoy Bike Shop</h2>
                        Your one stop bike shop website that offers variety of bikes,
                        bike accessories,<br> and bike parts that fits your bicycle needs.
                    </div>
                    <img src="images/LOGO.png" class="desc-img">
                </div>

                <div class="shop-content">
                    <img src="images/MISSION.png" class="mission-img">
                    <div class="mission-desc">
                        <h2>Mission</h2>
                        To provide a quality components of bicycles that can meet the expectations
                        of our customers. Especially to help our customers to discover and strengthen
                        their passion in cycling by assembling the most suitable, and reliable bicycle
                        available. Become one of well-organized, easy, and comfortable place to shop.
                    </div>
                </div>

                <div class="shop-content">
                    <div class="vision-desc">
                        <h2>Vision</h2>
                        A bike shop that can meet and enhance the community's bicycle needs and culture.
                        One spot where in buying will be efficient and gives access to each and every one.
                        Mostly to give appropriate service for bikes emergency needs.
                    </div>
                    <img src="images/VISION.png" class="vision-img">
                </div>
            </div>
        </div>

        <h2 class="faq-heading">FAQ'S</h2>
        <section class="faq-container">
            <div class="faq-one">
                <!-- faq question -->
                <p class="faq-page">Do you have a physical store?</p>
                <!-- faq answer -->
                <div class="faq-body">
                    <p>Yes, our physical store is located at Sandoval Ave. Corner Pagibig Homes Pinagbuhatan, Pasig City</p>
                </div>
            </div>
            <hr class="hr-line">
            <div class="faq-one">
                <!-- faq question -->
                <p class="faq-page">Do you provide a OR (Official Receipt)?</p>
                <!-- faq answer -->
                <div class="faq-body">
                    <p>Yes, just message us, go to contact and provide your TIN Number and Company Name inside the message box</p>
                </div>
            </div>
            <hr class="hr-line">
            <div class="faq-one">
                <!-- faq question -->
                <p class="faq-page">Can I cancel my order?</p>
                <!-- faq answer -->
                <div class="faq-body">
                    <p>Yes, but we strictly allow cancel orders if the status is still "pending".</p>
                </div>
            </div>
            <hr class="hr-line">
            <div class="faq-one">
                <!-- faq question -->
                <p class="faq-page">What is the policy for return and refund?</p>
                <!-- faq answer -->
                <div class="faq-body">
                    <p>If the products purchased by the customers have any damages or if the seller sent the wrong products, Canoy Bikes will accept the return and refund request as long as the customers provide some proof by sending images of the product.</p>
                </div>
            </div>
            <hr class="hr-line">
            <div class="faq-one">
                <!-- faq question -->
                <p class="faq-page">What is the store schedule?</p>
                <!-- faq answer -->
                <div class="faq-body">
                    <p>The store is open from Monday to Sunday - 8:00 AM to 6:00 PM</p>
                </div>
            </div>
            <hr class="hr-line">
            <div class="faq-one">
                <!-- faq question -->
                <p class="faq-page">Where can we contact Canoy Bike Shop?</p>
                <!-- faq answer -->
                <div class="faq-body">
                    <p>You can contact them through their mobile numbwe, facebook page and email address.<br>
                        Facebook: https://www.facebook.com/canoybikes<br>
                        Email: mrspikeeee@gmail.com<br>
                        Mobile number: 0999 681 6212</p>
                </div>
            </div>
            <hr class="hr-line">
            <div class="faq-one">
                <!-- faq question -->
                <p class="faq-page">What are the services in Canoy Bike Shop?</p>
                <!-- faq answer -->
                <div class="faq-body">
                    <p>Canoy Bike Shop can help repair and build your bicycles. They also offer different products such as built bicycles, accessories, and parts.</p>
                </div>
            </div>
            <hr class="hr-line">
            <div class="faq-one">
                <!-- faq question -->
                <p class="faq-page">How much is the rate for the services?</p>
                <!-- faq answer -->
                <div class="faq-body">
                    <p>It ranges from PHP 30.00 to PHP 800.00 - It depends on what services do you want. You can contact the store by answering the form in Contact Page.</p>
                </div>
            </div>
        </section>
    </main>
    <script src="js/about.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <!--Para mag dropwon yung menu-->

    <?php include "footer.php"; ?>