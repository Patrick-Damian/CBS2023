<?php include "header.php"; ?>
<?php
// add to cart function
if (isset($_POST['add_to_cart'])) {
    $usersId = $user_data["usersId"];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;

    $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE cart_name = '$product_name' AND usersId=$user_data[usersId]");

    if (mysqli_num_rows($select_cart) > 0) {
        $message[] = 'product already added to cart';
    } else {
        $insert_product = mysqli_query($con, "INSERT INTO `cart`(usersId, cart_name, price, image, quantity) VALUES('$usersId','$product_name', '$product_price', '$product_image', '$product_quantity')");
        $message[] = 'product added to cart succesfully';
    }
}

// add to wishlist function
if (isset($_POST['add_to_wishlist'])) {
    $usersId = $user_data["usersId"];
    $wish_name = $_POST['product_name'];
    $wish_img = $_POST['product_image'];
    $wish_price = $_POST['product_price'];

    $select_cart = mysqli_query($con, "SELECT * FROM `wishlist` WHERE wish_name = '$wish_name' AND usersId=$user_data[usersId]");

    if (mysqli_num_rows($select_cart) > 0) {
        $message[] = 'product already added to wishlist';
    } else {
        $insert_product = mysqli_query($con, "INSERT INTO `wishlist`(usersId, wish_name, wish_img, wish_price) VALUES('$usersId','$wish_name', '$wish_img', '$wish_price')");
        $message[] = 'product added to wishlist';
    }
}
?>

<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
        <div class="alert alert-dismissible fade show m-2" role="alert" style="background: #E6E6E6;">
            <h5 class="text-center">' . $message . '</h5>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
    };
};
?>

<?php
include('connection.php');
$prodId = $_GET['prod_id'];
$sql = "SELECT * FROM product_list WHERE prod_id=$prodId";
$result = $con->query($sql);
while ($row = $result->fetch_assoc()) {
    $image = $row['image'];
    $img1 = $row['img1'];
    $img2 = $row['img2'];
    $desc = $row['desc'];
    $prod_name = $row['prod_name'];
    $code = $row['code'];
    $stock = $row['stock'];
    $price = $row['price'];
    // echo '
?>
    <form method="post">
        <input type="hidden" class="form-control" name="usersId">
        <div class="product-view">
            <img id="imageBox" src="images/<?php echo $image ?>">
            <div class="labels">
                <p><?php echo $prod_name ?></p>
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $stock ?>" value="1">
                <p class="text-muted fs-6">Stocks: <?php echo $stock ?></p>
                <p>₱<?php echo number_format($price) ?>.00</p>
                <input type="hidden" name="product_name" value="<?php echo $prod_name ?>">
                <input type="hidden" name="product_price" value="<?php echo $price ?>">
                <input type="hidden" name="product_image" value="<?php echo $image ?>">
                <?php
                if (isset($_SESSION["usersId"])) {
                    echo '<button name="add_to_cart" class="btn btn-m btn-outline-danger" style="color:black ;"><i class="fa-solid fa-cart-plus"></i></button>';
                    echo '<button name="add_to_wishlist" class="btn btn-m btn-outline-danger" style="color:black ;"><i class="fa-solid fa-heart-circle-plus"></i></button>';
                } else {
                    echo '<a href="login.php" class="btn btn-m btn-outline-danger" style="color:black ;"><i class="fa-solid fa-cart-plus"></i></a>';
                    echo '<a href="login.php" class="btn btn-m btn-outline-danger" style="color:black ;"><i class="fa-solid fa-heart-circle-plus"></i></a>';
                }
                ?>
            </div>
        </div>
        <div class="product-small-img">
            <img src="images/<?php echo $image ?>" onclick="myFunction(this)">
            <img src="images/<?php echo $img1 ?>" onclick="myFunction(this)">
            <img src="images/<?php echo $img2 ?>" onclick="myFunction(this)">
        </div>
        <div class="desc">
            <h4>Product Description</h4>
            <p><?php echo $desc ?></p>
        </div>
    </form>
<?php
};
?>

<div class="review">
    <h2 class="heading">Reviews</h2>
</div>

<div class="user-review">
    <?php
    $sql = "SELECT * FROM `prod_review`"; // Fetch data from the table customers using id
    $result = mysqli_query($con, $sql);
    // $row = mysqli_fetch_assoc($result);
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <div class="user-content">
            <p><?php echo $row["cust_name"]; ?></p>
            <p><?php echo $row["comment"]; ?></p>
        </div>
    <?php
    }
    ?>
</div>



<div class="cat">
    <h3>Related Products</h3>
</div>
<div class="rel-prod">
    <div class="product1">
        <img src="images/Ragusa Brake Cleaner.jpg">
        <p>Ragusa Bicycle Rack</p>
    </div>
    <div class="product1">
        <img src="images/Ragusa Bicycle Rack.jpg">
        <p>Ragusa Brake Cleaner</p>
    </div>
    <div class="product1">
        <img src="images/Speedone Soldier Hub.jpg">
        <p>Speedone Solider Hub</p>
    </div>
    <div class="product1">
        <img src="images/Sagmit Cyrus Aero.jpg">
        <p>Sagmit Cyrus Aero</p>
    </div>
</div>

<script>
    // viewing angles
    function myFunction(smallImg) {
        var fullImg = document.getElementById("imageBox")
        fullImg.src = smallImg.src;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<!--Para mag dropwon yung menu-->

<?php include "footer.php"; ?>