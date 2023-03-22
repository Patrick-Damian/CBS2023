<?php 
session_start();

	include("connection.php");
	include("functions.php");

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		// $name = $_POST['name'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
		$user_name = $_POST['user_name'];
		$user_email = $_POST['user_email'];
		$contact = $_POST['contact'];
		$password = md5 ($_POST['password']);

		if(!empty($fname) && !empty($lname)&& !empty($user_name) && !empty($user_email) && !empty($contact)  && !empty($password))
		{

			$query = "INSERT INTO users (fname,lname,usersName,usersEmail,contact,password) VALUES ('$fname','$lname','$user_name','$user_email','$contact','$password')";

			mysqli_query($con, $query);

			header("Location: login.php");
			die;
		}
		else
		{
			echo "Please enter some valid information!";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/registerForm.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
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
                <i class="fas fa-shopping-cart"></i>
            </a>
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background:#630000; color:#fff; font-size:18px;">Profile</button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <?php
                    if (isset($_SESSION["usersId"])) {
                        echo "<li><a class='dropdown-item' href='profile.php?usersId=$user_data[usersId]' style='color:black; font-size:15px;'> $user_data[usersName]  </a></li>";
                        echo "<li><a class='dropdown-item' href='logout.php' style='color:black; font-size:15px;'>Logout</a></li>";
                    }
                    else {
                        echo "<li><a class='dropdown-item' href='login.php' style='color:black; font-size:15px;'>Login</a></li>";
                        echo "<li><a class='dropdown-item' href='register.php' style='color:black; font-size:15px;'>Register</a></li>";
                    }
                ?>
                </ul>
            </div>
        </div>
    </nav>


    <form method="post">
        <div class="register">
            <h2 class="register-header">Register Here</h2>
            <h4>Please fill in this form to create an account.</h4>

            <label  class="label-register" for="fname">First Name:</label>
            <input id="text" type="text" name="fname" placeholder="Enter First Name" style="margin-left:3.8rem;" required><br>

            <label  class="label-register" for="flname">Last Name:</label>
            <input id="text" type="text" name="lname" placeholder="Enter Last Name" style="margin-left:3.8rem;" required><br>

            <label class="label-register" for="user_name">User name:</label>
            <input id="text" type="text" name="user_name" placeholder="Enter Username" style="margin-left:3.8rem;" required><br>

            <label class="label-register" for="user_email">Email:</label>
            <input id="text" type="text" name="user_email" placeholder="Enter Email" style="margin-left:6rem;" required><br>

            <label class="label-register" for="contact">Contact No.:</label>
            <input id="text" type="text" name="contact" placeholder="Enter Contact No." style="margin-left:3.2rem;" required><br>

            <label class="label-register" for="password">Password:</label>
            <input id="text" type="password" name="password" placeholder="Password" style="margin-left:4rem;" required><br>

            <label class="label-register" for="confirm_password" required>Confirm Password:</label>
            <input id="text" type="password" name="confirm_password" placeholder="Confirm Password">

            <button type="submit" class="registerbtn">Register</button>

            <p>By creating an account you agree to our <button type="button" class="btn btn-m fw-bold" style="color:#000; border:none;" data-bs-toggle="modal" data-bs-target="#myModal">
                    Terms&Condition
                </button>.</p>
            <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
        </div>
        
    </form>

    <div class="modal" id="myModal">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Terms and Condition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <h5 class="fw-bold">Please read these terms and conditions carefully before using the Canoy Bike Shop website operated by Canoy Bikes.</h5>
                <p class="fw-bold mt-2">Condition of Use</p>
                <p class="text-start">By using this website, you certify that you have read and reviewed this Agreement and that you agree to comply with its terms. If you do not want to be bound by the terms of this Agreement, you are advised to leave the website accordingly. Canoy Bikes only grants use and access to this website, its products, and its services to those who have accepted its terms.</p>
                <p class="fw-bold mt-2">Privacy Policy</p>
                <p class="text-start">Before you continue using our website, we advise you to read our privacy policy regarding our user data collection. It will help you better understand our practices.</p>
                <p class="fw-bold mt-2">Age Restriction</p>
                <p class="text-start">You must be at least 18 (eighteen) years of age before you can use this website. By using this website, you warrant that you are at least 18 years of age, and you may legally adhere to this Agreement. Canoy Bikes assumes no responsibility for liabilities related to age misrepresentation.</p>
                <p class="fw-bold mt-2">Intellectual Property</p> 
                <p class="text-start">You agree that all materials, products, and services provided on this website are the property of Canoy Bikes, its affiliates, directors, officers, employees, agents, suppliers, or licensors including all copyrights, trade secrets, trademarks, patents, and other intellectual property. You also agree that you will not reproduce or redistribute Canoy’s Bikes intellectual property in any way, including electronic, digital, or new trademark registrations.</p>
                <p class="text-start">You grant Canoy Bikes a royalty-free and non-exclusive license to display, use, copy, transmit, and broadcast the content you upload and publish. For issues regarding intellectual property claims, you should contact the company to come to an agreement.</p> 
                <p class="fw-bold mt-2">User Accounts</p> 
                <p class="text-start">As a user of this website, you may be asked to register with us and provide private information. You are responsible for ensuring the accuracy of this information, and you are responsible for maintaining the safety and security of your identifying information. You are also responsible for all activities that occur under your account or password.</p>
                <p class="text-start">If you think there are any possible issues regarding the security of your account on the website, inform us immediately so we may address them accordingly.</p>
                <p class="text-start">We reserve all rights to terminate accounts, edit or remove content and cancel orders at our sole discretion.</p>
                <p class="fw-bold mt-2">Limitation on liability</p> 
                <p class="text-start">Canoy Bikes is not liable for any damages that may occur to you because of your misuse of our website.</p>
                <p class="text-start">Canoy Bikes reserves the right to edit, modify, and change this Agreement at any time. We shall let our users know of these changes through electronic mail. This Agreement is an understanding between Canoy Bikes and the user, and this supersedes and replaces all prior agreements regarding the use of this website.</p>
                <p class="fw-bold mt-2">Return and Refund Policy</p> 
                <p class="text-start">The return and refund policy of Canoy Bikes Shop states that the customers have the right to return and refund their purchased products if it has any damages or if the seller sent the wrong product to their customer. To accept their return and refund request customers must provide an image as proof that the purchased product sent to them is mistaken or damaged. It will be processed in 3-5 days.</p>
                <p class="fw-bold mt-2">Cancellation Policy</p> 
                <p class="text-start">When it comes to the Cancellation Policy of Canoy Bike Shop, the customer can only cancel their order if their order is in pending status except when their order is to be shipped or on hold by the courier, cancellation of the order will not be accepted. Upon canceling the order customer must choose the given reason provided by the shop.</p>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script> <!--Para mag dropwon yung menu-->
    <?php include "footer.php"; ?>