<?php
session_start();

include("../connection.php");
include("../functions.php");

$admin_data = check_login_admin($con);

// Function for deleting products
if (isset($_POST['delete'])) { //button name
    $id = $_POST['id'];

    $sql = "Delete from `user_order` where id=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-orders.php");
    } else {
        die(mysqli_error($con));
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $sql = "UPDATE `user_order` set `id`=$id,`status`='$status' where `id`=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-orders.php");
    } else {
        die(mysqli_error($con));
    }
}
// inventory function. nagbabawas automatically pag single product pero pag nag add to cart ng 2 or more product items di nagbabawas :( hahaha
if (isset($_POST['update'])) {
    $prod_id = $_POST['prod_id'];

    $sql_inv = "SELECT user_order.* , product_list.*  FROM user_order LEFT JOIN product_list  ON  user_order.prod_name = product_list.prod_name  ORDER BY `date` DESC"; // Fetch data from the table customers using id
    $result_inv = mysqli_query($con, $sql_inv);
    $row_inv = mysqli_fetch_assoc($result_inv);

    $new_stock = $row_inv['stock'] - $row_inv['qty'];
    
    $sql = "UPDATE `product_list` set `prod_id`=$prod_id,`stock`='$new_stock' where `prod_id`=$prod_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-orders.php");
    } else {
        die(mysqli_error($con));
    }
    //exit();
}
?>

<?php include "admin-header.php"; ?>

<!-- <div class="admin-orders"> -->
    <!-- inventory mag babawas automatic -->
    <?php
    // $sql = "SELECT * FROM `user_order`";
    // $result = mysqli_query($con, $sql);
    // while ($row = mysqli_fetch_assoc($result)) {
    //     if ($row["status"] == 'To Ship') {
    //         $status = $row['status'];
    //         //echo $status;
    //         $prod_qty = "SELECT * FROM `product_list` WHERE prod_id AND prod_name=".$prod_id["prod_id"] .$prod_name["prod_name"];
    //         $resultQty = mysqli_query($con, $prod_qty);
    //         $rowQty = mysqli_fetch_array($resultQty);
    //         //echo $rowQty["stock"];

    //     }
    // }
    // if (isset($_POST['update'])) {
    //     $inv_prod = mysqli_query($con, "SELECT * FROM `user_order`"); //chane query: checking for usersId
    //     $inv_qty = 0;
    //     if (mysqli_num_rows($inv_prod) > 0) {
    //         while ($product_item = mysqli_fetch_assoc($inv_prod)) {
    //             $product_name[] = $product_item['total_products'] . ' (' . $product_item['quantity'] . ') ';
    //             $product_price = ($product_item['price'] * $product_item['quantity']);
    //             $del_fee = 50;
    //             $price_total += $product_price += $del_fee;
    //         };
    //     };
    // }
    ?>
<!-- </div> -->

<div class="admin-orders">
    <div class="order-container">
        <h1 class="text-center mt-4 mb-4 fw-bold">Manage Orders</h1>
        <!-- Button trigger modal -->

        <!-- Table for displaying category -->
        <table class="table table-bordered border-dark align-middle table-responsive">
            <thead class="text-center">
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Place Order</th>
                    <th scope="col">Customer Details</th>
                    <!-- <th scope="col">Name</th>
                    <th scope="col">Number</th>
                    <th scope="col">Email</th> -->
                    <th scope="col">Method</th>
                    <th scope="col">Status</th>
                    <th scope="col">Address</th>
                    <th scope="col">Total Products</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $sql_inv = "SELECT * FROM user_order LEFT JOIN product_list  ON  user_order.prod_name = product_list.prod_name  ORDER BY `date` DESC"; // Fetch data from the table customers using id
                $result_inv = mysqli_query($con, $sql_inv);
                // $row_inv = mysqli_fetch_assoc($result_inv);

                // $sql = "SELECT * FROM `user_order` ORDER BY `date` DESC";
                // $result = mysqli_query($con, $sql);
                //$number = 1; //pang increment
                if ($result_inv) {
                    while ($row_inv = mysqli_fetch_assoc($result_inv)) {
                        $id = $row_inv['id'];
                        $prod_id = $row_inv['prod_id'];
                        $date = $row_inv['date'];
                        $place_order = $row_inv['place_order'];
                        $fname = $row_inv['fname'];
                        $lname = $row_inv['lname'];
                        $numbers = $row_inv['number']; //number ng user
                        $email = $row_inv['email'];
                        $method = $row_inv['method'];
                        $status = $row_inv['status'];
                        $flat = $row_inv['flat'];
                        $street = $row_inv['street'];
                        $city = $row_inv['city'];
                        $state = $row_inv['state'];
                        $zip_code = $row_inv['zip_code'];
                        $total_products = $row_inv['total_products'];
                        $total_price = $row_inv['total_price'];


                        echo '<tr>
                        <td scope="row" class="text-center">' . $date . '</td>
                    <td scope="row" class="text-center">' . $place_order . '</td>
                    <td class="text-start">' . $fname . '&nbsp;' . $lname . ' </br> ' . $numbers . ' </br>' . $email . '</td>
                    <td class="text-center">' . $method . '</td>
                    <td class="text-center">' . $status . '</td>
                    <td class="text-center">' . $flat . '&nbsp;' . $street . '&nbsp;' . $state . '&nbsp;' . $city . '&nbsp;' . $zip_code . '</td>
                    <td class="text-center">' . $total_products . '</td>
                    <td class="text-center">₱' . number_format($total_price) . '.00</td>

                    <td class="text-center">
                        <div class="btn-group">
                            <button type="submit" class="update-btn btn btn-sm" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#updateOrder" 
                            data-update_prod_id="' . $prod_id . '" data-update_order_id="' . $id . '" data-update_status="' . $status . '">
                                    <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" class="delete-btn btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteOrder" 
                                data-delete-order_id=' . $id . '>
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                    </tr>';
                        //$number++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Modal Content for updating order status-->
<div class="modal fade" id="updateOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="update-order_id" class="form-control" name="id">
                    <input type="hidden" id="update-prod_id" class="form-control" name="prod_id"> <!--nababawasan yung stocks pag nag update ng status si admin-->
                    <div class="input-group mb-3">
                        <label for="update-status" class="input-group-text">Status:</label>
                        <select class="form-select" id="update-status" name="status">
                            <option selected>Pending</option>
                            <option>To Ship</option>
                            <option>Shipped</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn" style="background-color: #630000;color:#fff;" name="update">Update</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Content for deleting category-->
<div class="modal fade" id="deleteOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="delete-id" class="form-control" name="id">
                    <div class="mb-3">
                        <p>Are you sure you want to delete this order/s?</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn" style="background-color: #630000;color:#fff;" name="delete">Delete</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "admin-footer.php"; ?>
<script>
    const update_btn = document.querySelectorAll('.update-btn');
    if (update_btn) {
        update_btn.forEach((edit) => {
            edit.addEventListener('click', () => {
                console.log('click');
                const id = edit.getAttribute('data-update_order_id');
                document.getElementById('update-order_id').value = id;

                const prod_id = edit.getAttribute('data-update_prod_id');
                document.getElementById('update-prod_id').value = prod_id;

                const status = edit.getAttribute('data-update_status');
                document.getElementById('update-status').value = status;
            });
        });
    };
    const del_btn = document.querySelectorAll('.delete-btn');
    if (del_btn) {
        del_btn.forEach((del) => {
            del.addEventListener('click', () => {
                console.log('click');
                const id = del.getAttribute('data-delete-order_id');
                document.getElementById('delete-id').value = id;
            });
        });
    };
</script>