<?php include "header.php"; ?>

<?php
// include('connection.php');
$usersId = $_GET['usersId'];
$sql = "SELECT * FROM users WHERE usersId='$usersId'"; // Fetch data from the table customers using id
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
?>
<?php
// Function for deleting products
if (isset($_POST['delete'])) { //button name
    $wish_id = $_POST['wish_id'];

    $sql = "DELETE FROM `wishlist` WHERE wish_id = '$wish_id'" ;
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: wishlist.php?usersId=$usersId");
    } else {
        die(mysqli_error($con));
    }
}
?>

<div class="grid-wishlist">
    <nav class="sidebar-nav">
        <div class="sidebar-list">
            <ul class="list-group">
                <!--bootstrap yang class na yan tangina mo!-->
                <li><a href="profile.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-user"></i>Account</a></li>
                <li><a href="address.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-location-dot"></i>Address</a></li>
                <li><a href="orderDetails.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-bag-shopping"></i>Orders</a></li>
                <li><a href="payment.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-peso-sign"></i>Payment</a></li>
                <li><a href="wishlist.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-sharp fa-solid fa-heart-circle-check"></i>Wishlist</a></li>
                <li><a href="return_refund.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-arrow-right-arrow-left"></i>Return & Refund</a></li>
            </ul>
        </div>
    </nav>

    <div class="wishlist-container">
        <h1 class="text-center mt-4 fw-bold">My Wishlist</h1>
        <!-- Table for displaying wishlist -->
        <input type="hidden" id="delete-id" class="form-control" name="wish_id">
        <table class="table mt-4">
            <thead class="text-center">
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Price</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `wishlist` WHERE usersId=$user_data[usersId]";
                $result = mysqli_query($con, $sql);
                $number = 1; //pang increment
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $wish_id = $row['wish_id'];
                        $wish_name = $row['wish_name'];
                        $wish_img = $row['wish_img']; //number ng user
                        $wish_price = $row['wish_price'];
                        echo '<tr>
                    <td class="text-center">' . $wish_name . '</td>
                    <td class="text-center"><img src="images/' . $wish_img . '" style="width:50px; height:50px;"></td>
                    <td class="text-center">₱' . number_format($wish_price)  . '.00</td>
                    <td class="text-center">
                        <button type="button" class="delete-btn btn btn-danger btn-m" data-bs-toggle="modal" data-bs-target="#deleteWishlist" data-delete-wish_id=' . $wish_id . '>
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                    </tr>';
                        $number++;
                    }
                }
                ?>

            </tbody>
        </table>
    </div>

    <!-- Modal Content for deleting category-->
    <div class="modal fade" id="deleteWishlist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Item/s?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" id="delete-wish_id" class="form-control" name="wish_id">
                        <div class="mb-3">
                            <p>Are you sure you want to delete this product?</p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const del_btn = document.querySelectorAll('.delete-btn');
    if (del_btn) {
        del_btn.forEach((del) => {
            del.addEventListener('click', () => {
                console.log('click');
                const wish_id = del.getAttribute('data-delete-wish_id');
                document.getElementById('delete-wish_id').value = wish_id;
            });
        });
    };
</script>


<!-- Dapat yung ganto nakalagy sa ibang files. yung footer ihihiwalay na lang para malinis -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<!--Para mag dropwon yung menu-->

<?php include "footer.php"; ?>