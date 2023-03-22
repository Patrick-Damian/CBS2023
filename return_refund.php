<?php include "header.php"; ?>

<?php
// include('connection.php');
$usersId = $_GET['usersId'];
$sql = "SELECT * FROM users WHERE usersId=$usersId ORDER BY `date` DESC"; // Fetch data from the table customers using id
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
?>

<div class="grid-return_refund">
    <nav class="sidebar-nav">
        <div class="sidebar-list">
            <ul class="list-group">
                <li><a href="profile.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-user"></i>Account</a></li>
                <li><a href="address.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-location-dot"></i>Address</a></li>
                <li><a href="orderDetails.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-bag-shopping"></i>Orders</a></li>
                <li><a href="payment.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-peso-sign"></i>Payment</a></li>
                <li><a href="wishlist.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-sharp fa-solid fa-heart-circle-check"></i>Wishlist</a></li>
                <li><a href="return_refund.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-arrow-right-arrow-left"></i>Return & Refund</a></li>
            </ul>
        </div>
    </nav>

    <div class="return_refund">
        <h1 class="text-center mt-4 fw-bold">Return and Refund</h1>
        <p class="text-start text-muted mt-4">Note: If the status of your return/refund item is accepted, please wait for our call to give you further instructions.</p>
        <table class="table table-bordered border-dark align-middle table-responsive mt-4">
            <thead class="text-center">
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Order No.</th>
                    <th scope="col">Item</th>
                    <th scope="col">Image</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `return_refund` WHERE usersId=$usersId ORDER BY `date` DESC";
                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td class="text-center"><?php echo $row["date"]; ?></td>
                        <td class="text-center"><?php echo $row["placeOrder"]; ?></td>
                        <td class="text-center"><?php echo $row["item"]; ?></td>
                        <td class="text-center"><img src="images/<?php echo $row["image"]; ?>" height="80" width="80" ></td>
                        <td class="text-center"><?php echo $row["qty"]; ?></td>
                        <td class="text-center"><?php echo $row["reason"]; ?></td>
                        <td class="text-center" style="color: red;"><?php echo $row["status"]; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</div>
<!-- Dapat yung ganto nakalagy sa ibang files. yung footer ihihiwalay na lang para malinis -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<!--Para mag dropwon yung menu-->

<?php include "footer.php"; ?>