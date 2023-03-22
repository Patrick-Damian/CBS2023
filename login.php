<?php
session_start();

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $user_name = $_POST['user_name'];
    $password = md5($_POST['password']);

    if (!empty($user_name) && !empty($password)) {
        //read from database
        $query = "select * from users where usersName = '$user_name'";
        $result = mysqli_query($con, $query);

        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {

                $user_data = mysqli_fetch_assoc($result);

                if ($user_data['password'] === $password) {

                    $_SESSION['usersId'] = $user_data['usersId'];
                    header("Location: index.php"); //nagbago
                    die;
                }
            }
        }
    } else {
        echo "<p>Incorrect username or password</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
                    echo '<i class="fas fa-shopping-cart"><span>'.$row_count.' </span></i>';
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

    <!-- Login -->
    <main>
        <form action="login.php" method="post">
            <div class="login">
                <h2 class="login-header">Login Here</h2>
                <h4>Please login your account</h4>

                <label class="label-login" for="user_name">Username:</label>
                <input type="text" placeholder="Enter your Username" name="user_name" id="username" required><br>

                <label class="label-login" for="password">Password:</label>
                <input type="password" placeholder="Enter your Password" name="password" id="password" required><br>


                <button name="submit" type="submit" class="loginbtn">Login</button>
                <p class="login-link">Don't have an account? <a href="register.php">Register here</a></p>
                <p class="admin-link">Admin? <a href="./Admin/admin-login.php">Login Here</a></p>
                <!-- <p class="login-link">Back to Home page? <a href="index.php">Home Page</a></p> -->
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <!--Para mag dropwon yung menu-->

    <?php include "footer.php"; ?>