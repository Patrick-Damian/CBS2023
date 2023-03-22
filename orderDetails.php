<?php include "header.php"; ?>

<?php
// include('connection.php');
$usersId = $_GET['usersId'];
$sql = "SELECT * FROM users WHERE usersId=$usersId"; // Fetch data from the table customers using id
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Function for adding return refund
if (isset($_POST['add'])) {
    $usersId = $_GET['usersId'];
    $placeOrder = $_POST['placeOrder'];
    $custName = $_POST['custName'];
    $item = $_POST['item'];
    $image = $_POST['image'];
    $qty = $_POST['qty'];
    $reason = $_POST['reason'];
    $status = $_POST['status'];

    $sql = "INSERT INTO `return_refund` (`usersId`,`placeOrder`,`custName`,`item`,`image`,`qty`,`reason`,`status`) VALUES ('$usersId','$placeOrder','$custName','$item','$image','$qty','$reason','$status')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: return_refund.php?usersId=$usersId");
    } else {
        die(mysqli_error($con));
    }
}
// fucntion for cancel button
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $sql = "UPDATE `user_order` set `status`='$status' where `id`=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: orderDetails.php?usersId=$usersId");
    } else {
        die(mysqli_error($con));
    }
}
// fucntion for receive button
if (isset($_POST['updated'])) {
    $id = $_POST['id'];
    $status = $_POST['receive'];

    $sql = "UPDATE `user_order` set `status`='$status' where `id`=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: orderDetails.php?usersId=$usersId");
    } else {
        die(mysqli_error($con));
    }
}

// Function for adding review
if (isset($_POST['review'])) {
    $cust_name = $_POST['cust_name'];
    $comment = $_POST['comment'];
    $reason = $_POST['reason'];
    $status = $_POST['status'];

    $sql = "INSERT INTO `prod_review` (`cust_name`,`comment`) VALUES ('$cust_name','$comment')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: orderDetails.php?usersId=$usersId");
    } else {
        die(mysqli_error($con));
    }
}
?>
<div class="grid-orders">
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
    <div class="orders">
        <h1 class="text-center mt-4 fw-bold">My Orders</h1>
        <p class="text-start text-muted">Note: Please go to payment section to pay your order. If failed to do, your order will be remove. Thank you!</p>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["status"] == 'Pending') {
                echo '
                <table class="table mt-4 table-bordered border-dark">
                <thead class="text-center">
                    <tr>
                        <th scope="col">Order Date</th>
                        <th scope="col">Order Number</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Status</th>
                        <th scope="col" colspan="5">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <form method="POST">
                        <tr>
                            <input type="hidden" class="form-control" name="id" value="'.$row["id"].'">
                            <input type="hidden" class="form-control" name="status" value="Canceled">
                            <input type="hidden" class="form-control" name="receive" value="Received">
                            <td class="text-center">'.$row["date"].'</td>
                            <td class="text-center">'.$row["place_order"].'</td>
                            <td class="text-center">₱ '. number_format ($row["total_price"]).'.00</td>
                            <td class="text-center"><a href="payment.php?usersId='.$row["usersId"].'" style="color: red ;">'.$row["pay_status"].'</a></td>
                            <td class="text-center" style="color: red;">'.$row["status"].'</td>
                            <td class="text-center">
                                <button type="button" class="view-btn btn text-light btn-sm" style="background:#630000;" data-bs-toggle="modal" data-bs-target="#myModal" 
                                    data-view_id="'.$row["id"].'" data-view_placeOrder="'.$row["place_order"].'" data-view_fname="'.$row["fname"].'" 
                                    data-view_lname="'.$row["lname"].'" data-view_address="'.$row["flat"].' '.$row["street"].' '.$row["state"].' '.$row["city"].' '.$row["zip_code"].'" 
                                    data-view_method="'.$row["method"].'" data-view_payStatus="'.$row["pay_status"].'" data-view_totalPrice="'.$row["total_price"].'" 
                                    data-view_status="'.$row["status"].'" data-view_products="'.$row["total_products"].'" data-view_price="'.$row["total_price"].'">
                                        View
                                </button>
                            </td>
                            <td class="text-center"><button type="button" disabled class="btn btn-secondary text-light btn-sm" data-bs-toggle="modal" data-bs-target="#review">Review Product</button></td>
                            <td class="text-center"><button type="submit" disabled class="btn btn-secondary text-light btn-sm" name="updated">Received</button></td>
                            <td class="text-center"><button type="submit" class="btn text-light btn-sm" style="background:#630000;" name="update">Cancel</button></td>
                            <td class="text-center">
                                <button type="button" disabled class="return_btn btn btn-secondary text-light btn-sm" data-bs-toggle="modal" data-bs-target="#return"
                                data-return_id="'.$row["id"].'" data-return_placeOrder="'.$row["place_order"].'" data-return_name="'.$row["fname"].' '.$row["lname"].' ">
                                    Return/Refund
                                </button>
                            </td>
                        </tr>
                    </form>
                </tbody>
            </table>
                ';
            } elseif ($row["status"] == 'Received') {
                echo '
                <table class="table mt-4 table-bordered border-dark">
                <thead class="text-center">
                    <tr>
                        <th scope="col">Order Date</th>
                        <th scope="col">Order Number</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Status</th>
                        <th scope="col" colspan="5">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <form method="POST">
                        <tr>
                            <input type="hidden" class="form-control" name="id" value="'.$row["id"].'">
                            <input type="hidden" class="form-control" name="status" value="Canceled">
                            <input type="hidden" class="form-control" name="receive" value="Received">
                            <td class="text-center">'.$row["date"].'</td>
                            <td class="text-center">'.$row["place_order"].'</td>
                            <td class="text-center">₱ '. number_format ($row["total_price"]).'.00</td>
                            <td class="text-center"><a href="payment.php?usersId='.$row["usersId"].'" style="color: red ;">'.$row["pay_status"].'</a></td>
                            <td class="text-center" style="color: red;">'.$row["status"].'</td>
                            <td class="text-center">
                                <button type="button" class="view-btn btn text-light btn-sm" style="background:#630000;"  data-bs-toggle="modal" data-bs-target="#myModal" 
                                    data-view_id="'.$row["id"].'" data-view_placeOrder="'.$row["place_order"].'" data-view_fname="'.$row["fname"].'" 
                                    data-view_lname="'.$row["lname"].'" data-view_address="'.$row["flat"].' '.$row["street"].' '.$row["state"].' '.$row["city"].' '.$row["zip_code"].'" 
                                    data-view_method="'.$row["method"].'" data-view_payStatus="'.$row["pay_status"].'" data-view_totalPrice="'.$row["total_price"].'" 
                                    data-view_status="'.$row["status"].'" data-view_products="'.$row["total_products"].'" data-view_price="'.$row["total_price"].'">
                                        View
                                </button>
                            </td>
                            <td class="text-center"><button type="button" class="btn text-light btn-sm" style="background:#630000;" data-bs-toggle="modal" data-bs-target="#review">Review Product</button></td>
                            <td class="text-center"><button type="submit" disabled class="btn btn-secondary text-light btn-sm" name="updated">Received</button></td>
                            <td class="text-center"><button type="submit" disabled class="btn btn-secondary text-light btn-sm" name="update">Cancel</button></td>
                            <td class="text-center">
                                <button type="button" class="return_btn btn text-light btn-sm" style="background:#630000;" data-bs-toggle="modal" data-bs-target="#return"
                                data-return_id="'.$row["id"].'" data-return_placeOrder="'.$row["place_order"].'" data-return_name="'.$row["fname"].' '.$row["lname"].' ">
                                    Return/Refund
                                </button>
                            </td>
                        </tr>
                    </form>
                </tbody>
            </table>
                ';
            } elseif ($row["status"] == 'Canceled') {
                echo '
                <table class="table mt-4 table-bordered border-dark">
                <thead class="text-center">
                    <tr>
                        <th scope="col">Order Date</th>
                        <th scope="col">Order Number</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Status</th>
                        <th scope="col" colspan="5">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <form method="POST">
                        <tr>
                            <input type="hidden" class="form-control" name="id" value="'.$row["id"].'">
                            <input type="hidden" class="form-control" name="status" value="Canceled">
                            <input type="hidden" class="form-control" name="receive" value="Received">
                            <td class="text-center">'.$row["date"].'</td>
                            <td class="text-center">'.$row["place_order"].'</td>
                            <td class="text-center">₱ '. number_format ($row["total_price"]).'.00</td>
                            <td class="text-center" style="color: grey ;">'.$row["pay_status"].'</td>
                            <td class="text-center" style="color: red;">'.$row["status"].'</td>
                            <td class="text-center">
                                <button type="button" class="view-btn btn text-light btn-sm" style="background:#630000;" data-bs-toggle="modal" data-bs-target="#myModal" 
                                    data-view_id="'.$row["id"].'" data-view_placeOrder="'.$row["place_order"].'" data-view_fname="'.$row["fname"].'" 
                                    data-view_lname="'.$row["lname"].'" data-view_address="'.$row["flat"].' '.$row["street"].' '.$row["state"].' '.$row["city"].' '.$row["zip_code"].'" 
                                    data-view_method="'.$row["method"].'" data-view_payStatus="'.$row["pay_status"].'" data-view_totalPrice="'.$row["total_price"].'" 
                                    data-view_status="'.$row["status"].'" data-view_products="'.$row["total_products"].'" data-view_price="'.$row["total_price"].'">
                                        View
                                </button>
                            </td>
                            <td class="text-center"><button type="button" disabled class="btn btn-secondary text-light btn-sm" data-bs-toggle="modal" data-bs-target="#review">Review Product</button></td>
                            <td class="text-center"><button type="submit" disabled class="btn btn-secondary text-light btn-sm" name="updated">Received</button></td>
                            <td class="text-center"><button type="submit" disabled class="btn btn-secondary text-light btn-sm" name="update">Cancel</button></td>
                            <td class="text-center">
                                <button type="button" disabled class="return_btn btn btn-secondary text-light btn-sm" data-bs-toggle="modal" data-bs-target="#return"
                                data-return_id="'.$row["id"].'" data-return_placeOrder="'.$row["place_order"].'" data-return_name="'.$row["fname"].' '.$row["lname"].' ">
                                    Return/Refund
                                </button>
                            </td>
                        </tr>
                    </form>
                </tbody>
            </table>
                ';
            } elseif ($row["status"] == 'To Ship') {
                echo '
                <table class="table mt-4 table-bordered border-dark">
                <thead class="text-center">
                    <tr>
                        <th scope="col">Order Date</th>
                        <th scope="col">Order Number</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Status</th>
                        <th scope="col" colspan="5">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <form method="POST">
                        <tr>
                            <input type="hidden" class="form-control" name="id" value="'.$row["id"].'">
                            <input type="hidden" class="form-control" name="status" value="Canceled">
                            <input type="hidden" class="form-control" name="receive" value="Received">
                            <td class="text-center">'.$row["date"].'</td>
                            <td class="text-center">'.$row["place_order"].'</td>
                            <td class="text-center">₱ '. number_format ($row["total_price"]).'.00</td>
                            <td class="text-center"><a href="payment.php?usersId='.$row["usersId"].'" style="color: red ;">'.$row["pay_status"].'</a></td>
                            <td class="text-center" style="color: red;">'.$row["status"].'</td>
                            <td class="text-center">
                                <button type="button" class="view-btn btn text-light btn-sm" style="background:#630000;" data-bs-toggle="modal" data-bs-target="#myModal" 
                                        data-view_id="'.$row["id"].'" data-view_placeOrder="'.$row["place_order"].'" data-view_fname="'.$row["fname"].'" 
                                        data-view_lname="'.$row["lname"].'" data-view_address="'.$row["flat"].' '.$row["street"].' '.$row["state"].' '.$row["city"].' '.$row["zip_code"].'" 
                                        data-view_method="'.$row["method"].'" data-view_payStatus="'.$row["pay_status"].'" data-view_totalPrice="'.$row["total_price"].'" 
                                        data-view_status="'.$row["status"].'" data-view_products="'.$row["total_products"].'" data-view_price="'.$row["total_price"].'">
                                            View
                                </button>
                            </td>
                            <td class="text-center"><button type="button" disabled class="btn btn-secondary text-light btn-sm" data-bs-toggle="modal" data-bs-target="#review">Review Product</button></td>
                            <td class="text-center"><button type="submit" disabled class="btn btn-secondary text-light btn-sm" name="updated">Received</button></td>
                            <td class="text-center"><button type="submit" disabled class="btn btn-secondary text-light btn-sm" name="update">Cancel</button></td>
                            <td class="text-center">
                                <button type="button" disabled class="return_btn btn btn-secondary text-light btn-sm" data-bs-toggle="modal" data-bs-target="#return"
                                data-return_id="'.$row["id"].'" data-return_placeOrder="'.$row["place_order"].'" data-return_name="'.$row["fname"].' '.$row["lname"].' ">
                                    Return/Refund
                                </button>
                            </td>
                        </tr>
                    </form>
                </tbody>
            </table>
                ';
            } elseif ($row["status"] == 'Shipped') {
                echo '
                <table class="table mt-4 table-bordered border-dark">
                <thead class="text-center">
                    <tr>
                        <th scope="col">Order Date</th>
                        <th scope="col">Order Number</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Status</th>
                        <th scope="col" colspan="5">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <form method="POST">
                        <tr>
                            <input type="hidden" class="form-control" name="id" value="'.$row["id"].'">
                            <input type="hidden" class="form-control" name="status" value="Canceled">
                            <input type="hidden" class="form-control" name="receive" value="Received">
                            <td class="text-center">'.$row["date"].'</td>
                            <td class="text-center">'.$row["place_order"].'</td>
                            <td class="text-center">₱ '. number_format ($row["total_price"]).'.00</td>
                            <td class="text-center"><a href="payment.php?usersId='.$row["usersId"].'" style="color: red ;">'.$row["pay_status"].'</a></td>
                            <td class="text-center" style="color: red;">'.$row["status"].'</td>
                            <td class="text-center">
                                <button type="button" class="view-btn btn text-light btn-sm" style="background:#630000;" data-bs-toggle="modal" data-bs-target="#myModal" 
                                        data-view_id="'.$row["id"].'" data-view_placeOrder="'.$row["place_order"].'" data-view_fname="'.$row["fname"].'" 
                                        data-view_lname="'.$row["lname"].'" data-view_address="'.$row["flat"].' '.$row["street"].' '.$row["state"].' '.$row["city"].' '.$row["zip_code"].'" 
                                        data-view_method="'.$row["method"].'" data-view_payStatus="'.$row["pay_status"].'" data-view_totalPrice="'.$row["total_price"].'" 
                                        data-view_status="'.$row["status"].'" data-view_products="'.$row["total_products"].'" data-view_price="'.$row["total_price"].'">
                                            View
                                </button>
                            </td>
                            <td class="text-center"><button type="button" disabled class="btn btn-secondary text-light btn-sm" data-bs-toggle="modal" data-bs-target="#review">Review Product</button></td>
                            <td class="text-center"><button type="submit" class="btn text-light btn-sm" style="background:#630000;" name="updated">Received</button></td>
                            <td class="text-center"><button type="submit" disabled class="btn btn-secondary text-light btn-sm" name="update">Cancel</button></td>
                            <td class="text-center">
                                <button type="button" disabled class="return_btn btn btn-secondary text-light btn-sm" data-bs-toggle="modal" data-bs-target="#return"
                                data-return_id="'.$row["id"].'" data-return_placeOrder="'.$row["place_order"].'" data-return_name="'.$row["fname"].' '.$row["lname"].' ">
                                    Return/Refund
                                </button>
                            </td>
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

<!-- The Modal for View -->
<!-- Okay na -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Billing Statement</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <h5 class="text-center mb-4 fw-bold">Please review the following details of this transaction</h5>
                <p class="fw-bold">Order Number: <span class="fw-normal" id="view-placeOrder"></span></p>

                <p class="fw-bold">Name: <span class="fw-normal" id="view-fname"></span>&nbsp;<span class="fw-normal" id="view-lname"></span></p>
                <p class="text-start fw-bold">Address: <span class="fw-normal" id="view-address"></span></p>
                <p class="fw-bold">Payment Method: <span class="fw-normal" id="view-method"></span></p>
                <p class="fw-bold">Payment Status: <span class="fw-normal" id="view-payStatus"></span></p>
                <p class="fw-bold">Total Orders: ₱<span class="fw-normal" id="view-totalProducts"></span>.00</p>
                <p class="fw-bold">Order Status: <span class="fw-normal" id="view-status"></span></p>

                <table class="table table-bordered border-dark table-sm align-middle">
                    <thead class="text-center">
                        <tr>
                            <th class="fw-bold" scope="col">Item Names</th>
                            <th class="fw-bold" scope="col">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span id="view-products"></span></td>
                            <td>₱<span id="view-price"></span>.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Content for return/refund-->
<div class="modal fade" id="return" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Return/Refund of items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <input type="hidden" class="form-control" name="usersId">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text text-light" style="background:#630000;">Order Number: </span>
                        <input type="text" id="return-placeOrder" class="form-control" name="placeOrder" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text text-light" style="background:#630000;">Name: </span>
                        <input type="text" id="return-name" class="form-control" name="custName">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text text-light" style="background:#630000;">Product Name: </span>
                        <input type="text" class="form-control" name="item">
                    </div>
                    <div class="input-group mb-3">
                        <label for="image" class="input-group-text text-light" style="background:#630000;">Image:</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                    <p class="text-muted" style="font-size: 12px; text-align:left;">Note: Please upload clear image of the product condition</p>
                    <div class="input-group mb-3">
                        <span class="input-group-text text-light" style="background:#630000;">Quantity:</span>
                        <input type="text" class="form-control" name="qty">
                    </div>

                    <h5>Reason for return/refund</h5>
                    <div class="input-group mb-3">
                        <label for="reason" class="input-group-text text-light" style="background:#630000;">Reason:</label>
                        <select class="form-select" id="update-status" name="reason">
                            <option selected>Choose...</option>
                            <option>Did not receive the full order (all tems in the order)</option>
                            <option>Did not receive part of the order (e,g. missing part(s) of item, missing part(s) of orders)</option>
                            <option>Received the wrong product(s) (seller sent me a wrong product)</option>
                            <option>Received a product with physical damage</option>
                            <option>Received a faulty product <br> (e.g. malfunction, does not work as intended)</option>
                        </select>
                    </div>
                    <input type="hidden" class="status" name="status" value="Pending">
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn text-light" name="add" style="background:#630000;">Send</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Content for Review/order recieved-->
<div class="modal fade" id="review" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Review of Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <?php
                $sql = "SELECT `fname`,`lname` FROM user_order WHERE usersId=$usersId"; // Fetch data from the table customers using id
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
                ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="review" class="form-label">Name:</label>
                        <input type="text" id="review_prod" class="form-control" name="cust_name" value="<?php echo $row["fname"]; ?> <?php echo $row["lname"]; ?>" style="width: 28rem;">
                    </div>
                    <div class="mb-3">
                        <label for="review" class="form-label">Comments:</label>
                        <input type="text" id="review_prod" class="form-control" name="comment" placeholder="Write your feedback here" style="width: 28rem;">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn text-light" name="review" style="background:#630000;">Send</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    const return_btn = document.querySelectorAll('.return_btn');
    if (return_btn) {
        return_btn.forEach((edit) => {
            edit.addEventListener('click', () => {
                console.log('click');
                // const id = edit.getAttribute('data-view_id');
                // document.getElementById('update-prod_id').value = prod_id;

                const placeOrder = edit.getAttribute('data-return_placeOrder');
                document.getElementById('return-placeOrder').value = placeOrder;

                const name = edit.getAttribute('data-return_name');
                document.getElementById('return-name').value = name;

                // const lname = edit.getAttribute('data-pay_lname');
                // document.getElementById('pay-lname').value = lname;
            });
        });
    };

    const view_btn = document.querySelectorAll('.view-btn');
    if (view_btn) {
        view_btn.forEach((edit) => {
            edit.addEventListener('click', () => {
                console.log('click');
                // const id = edit.getAttribute('data-view_id');
                // document.getElementById('update-prod_id').value = prod_id;

                const placeOrder = edit.getAttribute('data-view_placeOrder');
                document.getElementById('view-placeOrder').textContent = placeOrder;

                const fname = edit.getAttribute('data-view_fname');
                document.getElementById('view-fname').textContent = fname;

                const lname = edit.getAttribute('data-view_lname');
                document.getElementById('view-lname').textContent = lname;

                const address = edit.getAttribute('data-view_address');
                document.getElementById('view-address').textContent = address;

                const method = edit.getAttribute('data-view_method');
                document.getElementById('view-method').textContent = method;

                const totalPrice = edit.getAttribute('data-view_totalPrice');
                document.getElementById('view-totalProducts').textContent = totalPrice;

                const payStatus = edit.getAttribute('data-view_payStatus');
                document.getElementById('view-payStatus').textContent = payStatus;

                const status = edit.getAttribute('data-view_status');
                document.getElementById('view-status').textContent = status;

                const products = edit.getAttribute('data-view_products');
                document.getElementById('view-products').textContent = products;

                const price = edit.getAttribute('data-view_price');
                document.getElementById('view-price').textContent = price;
            });
        });
    };
</script>

<!-- Dapat yung ganto nakalagy sa ibang files. yung footer ihihiwalay na lang para malinis -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<!--Para mag dropwon yung menu-->

<?php include "footer.php"; ?>