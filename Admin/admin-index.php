<?php
session_start();

include("../connection.php");
include("../functions.php");

$admin_data = check_login_admin($con);

// Function for exporting sales to excel
if (isset($_POST["export"])) {
    $filename = "Export_excel.xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
}
?>

<?php include "admin-header.php"; ?>

<div class="admin-dashboard">
    <div class="row" style="margin-right: 20px;">
        <h1 class="text-center mt-4 mb-4">Admin Dashboard</h1><br>
        <div class="card me-3 mt-3" style="width: 17rem; background:#630000;">
            <div class="card-body">
                <h3 class="card-title text-center text-white">Total Users</h3>
                <h3 class="card-text text-center text-white mt-2">
                    <?php
                    $select_users = mysqli_query($con, "SELECT * FROM `users`") or die('query failed');
                    $row_count = mysqli_num_rows($select_users);
                    ?>
                    <span><?php echo $row_count; ?></span>
                </h3>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small stretched-link text-white" href="admin-users.php">View Details</a>
                <div class="small text-white"><i class="fa-solid fa-angles-right"></i></div>
            </div>
        </div>
        <div class="card me-3 mt-3" style="width: 17rem; background:#630000;">
            <div class="card-body">
                <h3 class="card-title text-center text-white">Total Products</h3>
                <h3 class="card-text text-center text-white mt-2">
                    <?php
                    $select_product = mysqli_query($con, "SELECT * FROM `product_list`") or die('query failed');
                    $row_count = mysqli_num_rows($select_product);
                    ?>
                    <span><?php echo $row_count; ?></span>
                </h3>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small stretched-link text-white" href="admin-products.php">View Details</a>
                <div class="small text-white"><i class="fa-solid fa-angles-right"></i></div>
            </div>
        </div>
        <div class="card me-3 mt-3" style="width: 17rem; background:#630000;">
            <div class="card-body">
                <h3 class="card-title text-center text-white">Total Orders</h3>
                <h3 class="card-text text-center text-white mt-2">
                    <?php
                    $select_order = mysqli_query($con, "SELECT * FROM `user_order`") or die('query failed');
                    $row_count = mysqli_num_rows($select_order);
                    ?>
                    <span><?php echo $row_count; ?></span>
                </h3>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small stretched-link text-white" href="admin-orders.php">View Details</a>
                <div class="small text-white"><i class="fa-solid fa-angles-right"></i></div>
            </div>
        </div>
        <div class="card me-3 mt-3" style="width: 17rem; background:#630000;">
            <div class="card-body">
                <h3 class="card-title text-white text-center">Total Categories</h3>
                <h3 class="card-text text-white text-center mt-2">
                    <?php
                    $select_category = mysqli_query($con, "SELECT * FROM `category`") or die('query failed');
                    $row_count = mysqli_num_rows($select_category);
                    ?>
                    <span><?php echo $row_count; ?></span>
                </h3>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small stretched-link text-white" href="admin-category.php">View Details</a>
                <div class="small text-white"><i class="fa-solid fa-angles-right"></i></div>
            </div>
        </div>
        <div class="card me-3 mt-3" style="width: 17rem; background:#630000;">
            <div class="card-body">
                <h3 class="card-title text-center text-white">Return/Refund</h3>
                <h3 class="card-text text-center text-white mt-2">
                    <?php
                    $select_category = mysqli_query($con, "SELECT * FROM `return_refund`") or die('query failed');
                    $row_count = mysqli_num_rows($select_category);
                    ?>
                    <span><?php echo $row_count; ?></span>
                </h3>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small stretched-link text-white" href="admin-return-cancel.php">View Details</a>
                <div class="small text-white"><i class="fa-solid fa-angles-right"></i></div>
            </div>
        </div>
        <div class="card me-3 mt-3" style="width: 17rem; background:#630000;">
            <div class="card-body">
                <h3 class="card-title text-center text-white">Inquiries</h3>
                <h3 class="card-text text-center text-white mt-2">
                    <?php
                    $select_category = mysqli_query($con, "SELECT * FROM `contact`") or die('query failed');
                    $row_count = mysqli_num_rows($select_category);
                    ?>
                    <span><?php echo $row_count; ?></span>
                </h3>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small stretched-link text-white" href="admin-contacts.php">View Details</a>
                <div class="small text-white"><i class="fa-solid fa-angles-right"></i></div>
            </div>
        </div>
        <div class="card me-3 mt-3" style="width: 17rem; background:#630000;">
            <div class="card-body">
                <h3 class="card-title text-center text-white">Payments</h3>
                <h3 class="card-text text-center text-white mt-2">
                    <?php
                    // $select_payments = mysqli_query($con, "SELECT * FROM `user_order`") or die('query failed');
                    $select_payment = mysqli_query($con, "SELECT `method` FROM `user_order`") or die('query failed');
                    $row = mysqli_fetch_assoc($select_payment);
                    $row_count = mysqli_num_rows($select_payment);
                    ?>
                    <span><?php echo $row_count; ?></span>
                </h3>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small stretched-link text-white" href="admin-payment.php">View Details</a>
                <div class="small text-white"><i class="fa-solid fa-angles-right"></i></div>
            </div>
        </div>

        <table class="table mt-4 table-bordered border-dark">
            <h2 class="text-center mt-4 fw-bold">Total Sale of Orders</h2>
            <!-- filter by date - weeks -->
            <form method="GET">
                <div class="row mt-4 mb-4" style="width:75%;">
                    <div class="col">
                        <div class="input-group input-group-sm me-2">
                            <span class="input-group-text" style="background-color: #630000;color:#fff;">From Date</span>
                            <input type="date" class="form-control" name="from_date" value="<?php if (isset($_GET['from_date'])) {
                                                                                                echo $_GET['from_date'];
                                                                                            } ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group input-group-sm me-2">
                            <span class="input-group-text" style="background-color: #630000;color:#fff;">To Date</span>
                            <input type="date" class="form-control w-50" name="to_date" value="<?php if (isset($_GET['to_date'])) {
                                                                                                    echo $_GET['to_date'];
                                                                                                } ?>">
                        </div>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-sm" name="filter" style="background-color: #630000;color:#fff;">Filter</button>
                    </div>
                </div>
            </form>
            <!-- ------------------------------------------------------ -->
            <!-- Export sales to excel -->
            <div class="export_btn">
                <a href="export_excel.php" class="btn btn-sm" style="background-color: #630000;color:#fff;">Export To Excel</a>
            </div>
            <!-- ------------------------------------------------------------------------------------------------ -->
            <thead class="text-center">
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Place Order</th>
                    <th scope="col">Total Products</th>
                    <th scope="col">Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $export_data = "SELECT * FROM user_order ORDER BY `date` DESC"; // Fetch data from the table customers using id
                $result = mysqli_query($con, $export_data);
                $grand_total = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $grand_total += ($row['total_price']);
                ?>
                    <tr>
                        <td><?php echo $row["date"]; ?></td>
                        <td><?php echo $row["place_order"]; ?></td>
                        <td><?php echo $row["total_products"]; ?></td>
                        <td>₱<?php echo number_format($row["total_price"]); ?>.00</td>
                    </tr>
                <?php
                }

                ?>
                <tr>
                    <td class="fw-bold" colspan="3">Total Sales</td>
                    <td class="fw-bold">₱<?php echo number_format($grand_total); ?>.00</td>
                </tr>
            </tbody>
        </table>
        <!-- Filtering sales by weeks -->
        <?php
        if (isset($_GET['filter'])) {
        ?>
            <table class="table mt-4 table-bordered border-dark">
            <h2 class="text-center mt-4 fw-bold">Sales per week</h2>
                <thead class="text-center">
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Place Order</th>
                        <th scope="col">Total Products</th>
                        <th scope="col">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                        $from_date = $_GET['from_date'];
                        $to_date = $_GET['to_date'];

                        $filter_query = "SELECT * FROM user_order WHERE `date` BETWEEN '$from_date' AND '$to_date' ORDER BY `date` DESC";
                        $filter_run = mysqli_query($con, $filter_query);
                        $grand_total = 0;

                        if (mysqli_num_rows($filter_run) > 0) {
                            while ($row = mysqli_fetch_assoc($filter_run)) {
                                $grand_total += ($row['total_price']);
                    ?>
                                <tr>
                                    <td><?php echo $row["date"]; ?></td>
                                    <td><?php echo $row["place_order"]; ?></td>
                                    <td><?php echo $row["total_products"]; ?></td>
                                    <td>₱<?php echo number_format($row["total_price"]); ?>.00</td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td class="fw-bold" colspan="3">Total Sales</td>
                                <td class="fw-bold">₱<?php echo number_format($grand_total); ?>.00</td>
                            </tr>

                    <?php
                        } else {
                            echo '<td colspan="4"><h3 class="text-center fw-bold" style="color: red;">No orders found.</h3></td>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        <?php
        }
        ?>
    </div>
</div>

<?php include "admin-footer.php"; ?>