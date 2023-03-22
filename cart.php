<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
?>
<?php

if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_quantity_query = mysqli_query($con, "UPDATE `cart` SET quantity = '$update_value' WHERE cart_id = '$update_id'");
    if ($update_quantity_query) {
        header('location:cart.php');
    };
};

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($con, "DELETE FROM `cart` WHERE cart_id = '$remove_id'");
    header('location:cart.php');
};

if (isset($_GET['delete_all'])) {
    mysqli_query($con, "DELETE FROM `cart` WHERE usersId=$user_data[usersId]"); //tama na to nadedelete nya yung cart kung sinong user ang naka login
    header('location:cart.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/carts.css">
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

    <!-- CART SECTION -->
    <div class="container-table">
        <h2 class="heading">Shopping Cart</h2>
        <table class="table table-bordered border-dark align-middle table-responsive">
            <thead class="text-center">
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Action</th>
            </thead>
            <tbody class="text-center">
                <?php
                if (isset($_SESSION["usersId"])) {
                    $select_cart = mysqli_query($con, "SELECT cart.*, product_list.prod_id,stock FROM cart LEFT JOIN product_list ON  cart.cart_name = product_list.prod_name WHERE usersId=$user_data[usersId]");
                    $grand_total = 0;
                    if (mysqli_num_rows($select_cart) > 0) {
                        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                ?>
                            <tr>
                                <td><img src="images/<?php echo $fetch_cart['image']; ?>" height="80" width="80" alt=""></td>
                                <td><?php echo $fetch_cart['cart_name']; ?></td>
                                <td>₱<?php echo number_format($fetch_cart['price']); ?>.00</td>
                                <td>
                                    <form action="" method="post">
                                        <div class="input-group text-center" style="width: 130px;margin-left:auto;margin-right:auto;">
                                            <button type="submit" class="input-group-text text-white decrement-btn updateQty" name="update_update_btn" style="background-color: #630000;">-</button>
                                            <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['cart_id']; ?>">
                                            <input type="number" name="update_quantity" class="form-control text-center" min="1" max="<?php echo $fetch_cart['stock']; ?>" value="<?php echo $fetch_cart['quantity']; ?>">
                                            <!-- <input type="submit" value="+" class="btn text-white" style="background-color: #630000;"  name="update_update_btn"> -->
                                            <button type="submit" class="input-group-text text-white increment-btn updateQty" name="update_update_btn" style="background-color: #630000;">+</button>
                                        </div>
                                    </form>
                                </td>
                                <td>₱<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?>.00</td>
                                <td><a href="cart.php?remove=<?php echo $fetch_cart['cart_id']; ?>" class="btn text-white" style="background-color: #630000;">Remove</a></td>
                            </tr>
                    <?php
                            $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                        };
                    };
                    ?>
                    <tr>
                        <td><a href="products.php" class="btn text-white" style="background-color: #630000;">Continue Shopping</a></td>
                        <td colspan="3" style="text-align:left;font-weight:bold;">Total</td>
                        <td>₱<?php echo number_format($grand_total); ?>.00</td>
                        <td><a href="cart.php?delete_all" onclick="return confirm('Are you sure you want to delete all?');" class="btn text-white" style="background-color: #630000;">Delete all</a></td>
                    </tr>
            </tbody>
        <?php
                } else {
                    header("Location: login.php");
                }
        ?>
        </table>
        <!-- Chnage functions if ever -->
        <!-- Okay na yung condition -->
        <?php
        $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE usersId=$user_data[usersId]");

        if (mysqli_num_rows($select_cart) == 0) {
            echo '<h2 class="text-center mt-4 mb-6">Your Cart is Empty!</h2>';
        } else {
            echo " <div class='float-md-end btn' style='background-color: #630000;'>
                <a href='checkout.php' style='text-decoration:none;color:#fff;'>Proceed to Checkout</a>
                </div>";
        }

        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <!--Para mag dropwon yung menu-->

    <?php include "footer.php"; ?>