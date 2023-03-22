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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
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

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        //something was posted
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        if (!empty($fname) && !empty($lname) && !empty($email) && !empty($message)) {
            $query = "INSERT INTO contact (fname,lname,email,message) VALUES ('$fname','$lname','$email','$message')";

            mysqli_query($con, $query);


            echo '
        <div class="alert alert-dismissible fade show m-2" role="alert" style="background: #E6E6E6;">
            <h5 class="text-center fw-bold p-0">Sent Successfully</h5>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
        } else {
            echo "Please enter some valid information!";
        }
    }
    ?>

    <h1 class="text-center mt-4 mb-4 fw-bold">Contact Us</h1>
    <div class="content-contact">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61796.45732369249!2d121.04386602932351!3d14.526051151889897!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c7cbefd12d23%3A0x228188ff2f4da84a!2sCanoy%20Bicycle%20Shop!5e0!3m2!1sen!2sph!4v1669910373325!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <div class="map-responsive">

            <p class="text-start fs-5">Welcome to Canoy Bikes Shop, if you have any concerns regarding to our
                products and services feel free to answer the details below and click the submit
                button. Thank you for browsing and happy shopping!</p>
            <form method="post">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <span class="input-group-text text-light fw-semi-bold" style="background:#630000;border: 2px solid #000;">First Name:</span>
                        <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" required style="border: 2px solid #000;">
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text text-light fw-semi-bold" style="background:#630000;border: 2px solid #000;">Last Name:</span>
                        <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" required style="border: 2px solid #000;">
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text text-light fw-semi-bold" style="background:#630000;border: 2px solid #000;">Email:</span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required style="border: 2px solid #000;">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="msg" name="message" placeholder="Enter your message here" required rows="3" style="border: 2px solid #000;"></textarea>
                    </div>

                    <p class="text-start text-muted">Note: If you want to request for an OR (Official Receipt), please provide your TIN number and Company Name. Thank you!</p>

                    <button type="submit" class="btn btn-primary mt-3 text-center">Send</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <!--Para mag dropwon yung menu-->

    <?php include "footer.php"; ?>