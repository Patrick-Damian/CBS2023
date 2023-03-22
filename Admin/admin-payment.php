<?php
session_start();

include("../connection.php");
include("../functions.php");

$admin_data = check_login_admin($con);

// Function for deleting payments per id in payment stable
if (isset($_POST['delete'])) { //button name
    $pay_id = $_POST['pay_id'];

    $sql = "Delete from `payment` where pay_id=$pay_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-payment.php");
    } else {
        die(mysqli_error($con));
    }
}
// Function for deleting payments per id in user_order table
if (isset($_POST['deleteCod'])) { //button name
    $id = $_POST['id'];

    $sql = "Delete from `user_order` where id=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-payment.php");
    } else {
        die(mysqli_error($con));
    }
}
if (isset($_POST['updateStatus'])) {
    $id = $_POST['id'];
    $payStatus = $_POST['payStatus'];

    $sql = "UPDATE `user_order` set `id`=$id,`pay_status`='$payStatus' where `id`=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-payment.php");
    } else {
        die(mysqli_error($con));
    }
}

if (isset($_POST['updateAllStatus'])) {
    $id = "1";
    $payStatus = $_POST['payStatus'];

    $sql = "UPDATE `user_order` set `pay_status`='$payStatus' where `visible`=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-payment.php");
    } else {
        die(mysqli_error($con));
    }
}
?>
<?php include "admin-header.php"; ?>
<div class="admin-payment">
    <div class="payment-container">
        <h1 class="text-center mt-3 fw-bold">Payment History</h1>
        <h4 class="text-start mt-4 fw-semibold">Gcash Transaction</h4>
        <!-- check all tapos button para ma change lahat ng unpaid to paid -->
        <?php
        $sql = "SELECT payment.*, user_order.id,pay_status FROM payment LEFT JOIN user_order ON  payment.placeOrder = user_order.place_order ORDER BY `date` DESC"; // Fetch data from the table customers using id
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result)
        ?>
        <button type="buttom" class="update-btn btn btn-sm mt-3" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#updateAllStatus">
            Update Payment
        </button>
        <!-- Modal Content for updating payment status in payment tble-->
        <div class="modal fade" id="updateAllStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update All Payment Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                            <input type="hidden"  class="form-control">
                            <div class="input-group mb-3">
                                <label for="update-status" class="input-group-text">Status:</label>
                                <select class="form-select" name="payStatus">
                                    <option selected>Unpaid</option>
                                    <option>Paid</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn" style="background-color: #630000;color:#fff;" name="updateAllStatus">Update</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <table class="table table-bordered border-dark align-middle table-responsive mt-4">
            <thead class="text-center">
                <tr>
                    <th><input type="checkbox"></th>
                    <th scope="col">Payment Date</th>
                    <th scope="col">Order Number</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Refernce No.</th>
                    <th scope="col">Status</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT payment.*, user_order.id,pay_status,visible FROM payment LEFT JOIN user_order ON  payment.placeOrder = user_order.place_order ORDER BY `date` DESC"; // Fetch data from the table customers using id
                $result = mysqli_query($con, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $pay_id = $row['pay_id'];
                        $id = $row['id'];
                        $placeOrder = $row['placeOrder'];
                        $custName = $row['custName'];
                        $amount = $row['amount'];
                        $ref_num = $row['ref_num'];
                        $pay_status = $row['pay_status'];
                        $img = $row['img'];
                        $date = $row['date'];
                        $visible = $row['visible'];
                        //' . $visible = 0 ? "checked" : "" . '
                        echo '
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" onclick="toggleCheckbox(this)" value="' . $id . '">
                            </td>
                            <td class="text-center">' . $date . '</td>
                            <td class="text-center">' . $placeOrder . '</td>
                            <td class="text-center">' . $custName . '</td>
                            <td class="text-center">₱' . number_format($amount) . '.00</td>
                            <td class="text-center">' . $ref_num . '</td>
                            <td class="text-center" style="color: red;">' . $pay_status . '</td>
                            <td class="text-center">
                                <button type="button" class="view-btn btn btn-sm" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#viewPayment" 
                                data-view-viewId="' . $pay_id . '" data-view-viewImg="' . $img . '">view image</button>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="submit" class="update-btn btn btn-sm" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#updateCod" 
                                        data-update_payStatus_id="' . $id . '" data-update_payStatus="' . $pay_status . '">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button type="button" class="delete-btn btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUser" data-delete-payId="' . $pay_id . '">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        ';
                    }
                }
                ?>
            </tbody>
        </table>
        <h4 class="text-start mt-4 fw-semibold">COD Transaction</h4>
        <table class="table table-bordered border-dark align-middle table-responsive mt-4">
            <thead class="text-center">
                <tr>
                    <th scope="col">Payment Date</th>
                    <th scope="col">Order Number</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Payment</th>
                    <th scope="col">Order Status</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM user_order ORDER BY `date` DESC"; // Fetch data from the table customers using id
                $result = mysqli_query($con, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $fname = $row['fname'];
                        $lname = $row['lname'];
                        $place_order = $row['place_order'];
                        $total_price = $row['total_price'];
                        $method = $row['method'];
                        $status = $row['status'];
                        $pay_status = $row['pay_status'];
                        $date = $row['date'];
                        if ($method == 'cash on delivery') {
                            echo '
                        <tr>
                            <td class="text-center">' . $date . '</td>
                            <td class="text-center">' . $place_order . '</td>
                            <td class="text-center">' . $fname . ' &nbsp; ' . $lname . '</td>
                            <td class="text-center">₱' . number_format($total_price) . '.00</td>
                            <td class="text-center">' . $method . '</td>
                            <td class="text-center">' . $status . '</td>
                            <td class="text-center" style="color: red;">' . $pay_status . '</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="submit" class="update-btn btn btn-sm" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#updateCod" 
                                        data-update_payStatus_id="' . $id . '" data-update_payStatus="' . $pay_status . '">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button type="button" class="delete-cod btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCod" data-delete-id="' . $id . '">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        ';
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Content for updating payment status in payment tble-->
<div class="modal fade" id="updateCod" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Payment Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="update-order_id" class="form-control" name="id">
                    <div class="input-group mb-3">
                        <label for="update-status" class="input-group-text">Status:</label>
                        <select class="form-select" id="update-payStatus" name="payStatus">
                            <option selected>Unpaid</option>
                            <option>Paid</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn" style="background-color: #630000;color:#fff;" name="updateStatus">Update</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Content for viewing payments located in payment table-->
<div class="modal fade" id="viewPayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="view-payId" class="form-control" name="pay_id">
                <div class="mb-3">
                    <img id="view-img" style="width: 100%;">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Content for deleting payments for gcash/ payment table-->
<div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="delete-id" class="form-control" name="pay_id">
                    <div class="mb-3">
                        <p>Are you sure you want to delete this payment?</p>
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

<!-- Modal Content for deleting payments for cod/ user_order table-->
<div class="modal fade" id="deleteCod" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="delete-cod-id" class="form-control" name="id">
                    <div class="mb-3">
                        <p>Are you sure you want to delete this payment?</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn" style="background-color: #630000;color:#fff;" name="deleteCod">Delete</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "admin-footer.php"; ?>
<script>
    //ipdating multiple data
    function toggleCheckbox(box) {
        var id = $(box).attr("value");

        if ($(box).prop("checked") == true) {
            var visible = 1;
        } else {
            var visible = 0;
        }

        var data = {
            "search_data": 1,
            "id": id,
            "visible": visible
        };

        $.ajax({
            type: "post",
            url: "code.php",
            data: data,
            success: function(response) {
                //alert("Data Checked")
            }
        });
    }



    // updating payment status
    const update_btn = document.querySelectorAll('.update-btn');
    if (update_btn) {
        update_btn.forEach((edit) => {
            edit.addEventListener('click', () => {
                console.log('click');
                const id = edit.getAttribute('data-update_payStatus_id');
                document.getElementById('update-order_id').value = id;

                const payStatus = edit.getAttribute('data-update_payStatus');
                document.getElementById('update-payStatus').value = payStatus;
            });
        });
    };
    // viewing image
    const img_btn = document.querySelectorAll('.view-btn');
    if (img_btn) {
        img_btn.forEach((view) => {
            view.addEventListener('click', () => {
                console.log('click');
                const pay_id = view.getAttribute('data-view-viewId');
                document.getElementById('view-payId').value = pay_id;
                const viewImg = view.getAttribute('data-view-viewImg');
                document.getElementById('view-img').src = `../images/${viewImg}`;
            });
        });
    };

    // for payment table
    const del_btn = document.querySelectorAll('.delete-btn');
    if (del_btn) {
        del_btn.forEach((del) => {
            del.addEventListener('click', () => {
                console.log('click');
                const payId = del.getAttribute('data-delete-payId');
                document.getElementById('delete-id').value = payId;
            });
        });
    };
    // for cod located at user_order
    const del_cod = document.querySelectorAll('.delete-cod');
    if (del_cod) {
        del_cod.forEach((del) => {
            del.addEventListener('click', () => {
                console.log('click');
                const id = del.getAttribute('data-delete-id');
                document.getElementById('delete-cod-id').value = id;
            });
        });
    };
</script>