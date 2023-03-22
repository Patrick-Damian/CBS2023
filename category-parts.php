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
    <link rel="stylesheet" href="./css/product.css">
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
    <?php
    // add to cart function
    if (isset($_POST['add_to_cart'])) {
        $usersId = $user_data['usersId'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = 1;

        // subject to change okay naman kaso gusto ko mafilter nya yung kasing name nya if meron naka add dapat di na mag add
        // $sql = "INSERT INTO `cart` (`usersId`, `cart_name`, `price`, `image`, `quantity`) VALUES ('$usersId','$product_name', '$product_price', '$product_image', '$product_quantity')";
        // $result = mysqli_query($con, $sql);
        // if ($result) {
        //     // header("Location: products.php");
        //     $message[] = 'product added to cart succesfully';
        // } else {
        //     die(mysqli_error($con));
        // }
        $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE cart_name = '$product_name' AND usersId=$user_data[usersId]");

        if (mysqli_num_rows($select_cart) > 0) {
            $message[] = 'product already added to cart';
        } else {
            $insert_product = mysqli_query($con, "INSERT INTO `cart`(usersId, cart_name, price, image, quantity) VALUES('$usersId','$product_name', '$product_price', '$product_image', '$product_quantity')");
            $message[] = 'product added to cart succesfully';
        }
    }
    ?>
    <!-- Products Code -->
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            // echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
            echo '
            <div class="alert alert-dismissible fade show m-2" role="alert" style="background: #E6E6E6;">
                <h5 class="text-center">' . $message . '</h5>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        };
    };
    ?>

    <div class="cat-list">
        <ul class="list-group list-group-horizontal mt-3 borderless fs-5">
            <li class="list-group-item" style="border: none;"><a href="products.php">All</a></li>
            <li class="list-group-item" style="border: none;"><a href="category-bikes.php">Bikes</a></li>
            <li class="list-group-item" style="border: none;"><a href="category-accessories.php">Accessories</a></li>
            <li class="list-group-item" style="border: none;"><a href="category-parts.php">Parts</a></li>
        </ul>
    </div>

    <!--search bar function -->
    <!-- may mali paaa hahahah -->
    <form method="post">
        <div class="input-group mb-5 mt-3" style="width:40%;">
            <input type="text" class="form-control" placeholder="Search product here" name="search" style="border: 2px solid #000;">
            <button type="submit" class="btn text-light" name="search_prod" style="background:#630000;"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </form>

    <div class="products">
        <div class="box-container">
            <?php
            if (isset($_POST['search_prod'])) {
                $search = $_POST['search'];

                $sql_search = "SELECT * FROM `product_list` WHERE prod_id LIKE '%$search%' OR prod_name LIKE '%$search%' OR category LIKE '%$search%'";
                $resultSearch = mysqli_query($con, $sql_search);
                if ($resultSearch) {
                    if (mysqli_num_rows($resultSearch) > 0) {
                        while ($row = mysqli_fetch_assoc($resultSearch)) {
                            echo '
                            <form action="" method="post">
                                <div class="box">
                                    <input type="hidden" name="prod_id" value="' . $row['prod_id'] . '" />
                                    <a href="productView.php?prod_id=' . $row['prod_id'] . '"><img src="images/' . $row['image'] . '" alt=""></a>
                                    <h3>' . $row['prod_name'] . '</h3>
                                    <div class="price">₱' . number_format($row['price']) . '.00</div>
                                    <input type="hidden" name="product_name" value="' . $row['prod_name'] . '">
                                    <input type="hidden" name="product_price" value="' . $row['price'] . '">
                                    <input type="hidden" name="product_image" value="' . $row['image'] . '">
                                ';
                            if (isset($_SESSION["usersId"])) { //chnages; condition to check if the user is login or not
                                echo '<input type="submit" class="btn-cart" value="Add to Cart" name="add_to_cart">';
                            } else {
                                echo '<a href="login.php" class="btn btn-cart" style="background: #630000;color:#fff;">Add to Cart</a>';
                            }
                            echo '    
                                </div>
                            </form>';
                        }
                    } else {
                        echo '<h1 class="text-center">Product is not Available</h1>';
                    }
                }
                exit();
            }
            ?>
        </div>
    </div>
    <!-- ------------------------------------------------------------------------------------------------------------------ -->

    <div class="products">
        <div class="box-container">
            <?php
            $select_products = mysqli_query($con, "SELECT * FROM `product_list` WHERE `category` = 'parts'");
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_products)) {
                    // $prod_id = $fetch_product ['prod_id'];
            ?>
                    <form action="" method="post">
                        <input type="hidden" class="form-control" name="usersId">
                        <div class="box">
                            <input type="hidden" name="prod_id" value="<?php echo $fetch_product['prod_id']; ?>" />
                            <a href="productView.php?prod_id=<?php echo $fetch_product['prod_id']; ?>"><img src="images/<?php echo $fetch_product['image']; ?>" alt=""></a>
                            <h3><?php echo $fetch_product['prod_name']; ?></h3>
                            <div class="price">₱<?php echo number_format($fetch_product['price']); ?>.00</div>
                            <input type="hidden" name="product_name" value="<?php echo $fetch_product['prod_name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                            <?php
                            if (isset($_SESSION["usersId"])) { //chnages; condition to check if the user is login or not
                                echo '<input type="submit" class="btn-cart" value="Add to Cart" name="add_to_cart">';
                            } else {
                                echo '<a href="login.php" class="btn btn-cart" style="background: #630000;color:#fff;">Add to Cart</a>';
                            }
                            ?>

                        </div>
                    </form>
            <?php
                };
            };
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <!--Para mag dropwon yung menu-->

    <?php include "footer.php"; ?>