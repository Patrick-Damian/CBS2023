<?php include "header.php"; ?>

<?php
$usersId = $_GET['usersId'];
$sql = "SELECT * FROM users WHERE usersId=$usersId"; // Fetch data from the table customers using id
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);


// Function for uploading of ss of gcash
if (isset($_POST['add'])) {
    $usersId = $_GET['usersId'];
    $placeOrder = $_POST['placeOrder'];
    $custName = $_POST['custName'];
    $amount = $_POST['amount'];
    $ref_num = $_POST['ref_num'];
    $img = $_POST['img'];

    $sql = "INSERT INTO `payment` (`usersId`,`placeOrder`,`custName`,`amount`,`ref_num`,`img`) VALUES ('$usersId','$placeOrder','$custName','$amount','$ref_num','$img')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: payment.php?usersId=$usersId");
    } else {
        die(mysqli_error($con));
    }
}

?>

<div class="grid-payment">
    <!-- Dapat nasa loob ng grid lahat to -->
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

    <?php
    $sql = "SELECT * FROM user_order WHERE usersId=$usersId ORDER BY `date` DESC"; // Fetch data from the table customers using id
    $result = mysqli_query($con, $sql);
    // $row = mysqli_fetch_assoc($result);
    ?>
    <div class="payment-content">
        <h1 class="text-center mt-4 fw-bold">Payment Transaction</h1>
        <p class="text-start text-muted mt-4">Note: Please pay your order within 24hrs of purchase. If failed to do, your order will be remove. Thank you!</p>

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["method"] == 'gcash') {
                echo '
                <table class="table mt-4 table-bordered border-dark">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">Order Date</th>
                            <th scope="col">Order Number</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Payment Method</th>
                            <th scope="col">Payment Status</th>
                            <th scope="col" colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="POST">
                            <tr>
                                <input type="hidden" class="form-control" name="id" value="'.$row["id"].' ">
                                <td class="text-center">'.$row["date"].' </td>
                                <td class="text-center">'.$row["place_order"].' </td>
                                <td class="text-center">₱'.number_format($row["total_price"]).'.00</td>
                                <td class="text-center">'.$row["method"].' </td>
                                <td class="text-center" style="color: red;">'.$row["pay_status"].' </td>
                                <td class="text-center">                                                                                                                
                                    <button type="button" class="pay_btn btn text-light btn-sm" style="background:#630000;" data-bs-toggle="modal" data-bs-target="#payment_details" data-pay_id="'.$row["id"].'" data-pay_placeOrder="'.$row["place_order"].'" data-pay_name="'.$row["fname"].' '.$row["lname"].'" data-pay_amount="'.$row["total_price"].'">
                                        Upload Screenshot
                                    </button>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                </table>
                ';
            } else {
                echo '
                <table class="table mt-4 table-bordered border-dark">
                <thead class="text-center">
                    <tr>
                        <th scope="col">Order Date</th>
                        <th scope="col">Order Number</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <form method="POST">
                        <tr>
                            <input type="hidden" class="form-control" name="id" value="'.$row["id"].' ">
                            <td class="text-center">'.$row["date"].' </td>
                            <td class="text-center">'.$row["place_order"].' </td>
                            <td class="text-center">₱'.number_format($row["total_price"]).' .00</td>
                            <td class="text-center">'.$row["method"].' </td>
                            <td class="text-center" style="color: red;">'.$row["pay_status"].' </td>
                        </tr>
                    </form>
                </tbody>
            </table>
                ';
            }
        }
        ?>
    </div>
</div>


<!-- Modal Content for gcash qr-->
<div class="modal fade" id="payment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Scan QR To Pay</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="images/gcash_canoy.png" width="250" height="300">
            </div>

            <div class="modal-footer">
                <!-- <button type="submit" class="btn btn-primary" name="add">Confirm</button> -->
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Content for uploading screenshot-->
<!-- di pa tapos -->
<div class="modal fade" id="payment_details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Attached Screenshot or Image here</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <input type="hidden" class="form-control" name="usersId">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text text-light" style="background:#630000;">Order Number: </span>
                        <input type="text" id="pay-placeOrder" class="form-control" name="placeOrder" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text text-light" style="background:#630000;">Name: </span>
                        <input type="text" id="pay-name" class="form-control" name="custName">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text text-light" style="background:#630000;">Amount: </span>
                        <input type="text" id="pay-amount" class="form-control" name="amount">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text text-light" style="background:#630000;">Reference Number: </span>
                        <input type="text" class="form-control" name="ref_num" placeholder="Enter Reference Number" required>
                    </div>
                    <div class="input-group mb-3">
                        <label for="image" class="input-group-text text-light" style="background:#630000;">Image:</label>
                        <input type="file" class="form-control" name="img" required>
                    </div>
                    <p class="text-start text-muted">Note: Please upload the screenshot of your Gcash here</p>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn text-light" name="add" style="background:#630000;">Send</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const pay_btn = document.querySelectorAll('.pay_btn');
    if (pay_btn) {
        pay_btn.forEach((edit) => {
            edit.addEventListener('click', () => {
                console.log('click');

                const placeOrder = edit.getAttribute('data-pay_placeOrder');
                document.getElementById('pay-placeOrder').value = placeOrder;

                const name = edit.getAttribute('data-pay_name');
                document.getElementById('pay-name').value = name;

                const amount = edit.getAttribute('data-pay_amount');
                document.getElementById('pay-amount').value = amount;
            });
        });
    };
</script>


<!-- Dapat yung ganto nakalagy sa ibang files. yung footer ihihiwalay na lang para malinis -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<!--Para mag dropwon yung menu-->

<?php include "footer.php"; ?>