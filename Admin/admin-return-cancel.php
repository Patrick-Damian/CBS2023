<?php
session_start();

include("../connection.php");
include("../functions.php");

$admin_data = check_login_admin($con);

// Function for deleting products
if (isset($_POST['delete'])) { //button name
    $rr_id = $_POST['rr_id'];

    $sql = "Delete from `return_refund` where rr_id=$rr_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-return-cancel.php");
    } else {
        die(mysqli_error($con));
    }
}

if (isset($_POST['update'])) {
    $rr_id = $_POST['rr_id'];
    $status = $_POST['status'];

    $sql = "UPDATE `return_refund` set `rr_id`=$rr_id,`status`='$status' where `rr_id`=$rr_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-return-cancel.php");
    } else {
        die(mysqli_error($con));
    }
}
?>
<?php include "admin-header.php"; ?>
<div class="admin-return-cancel">
    <div class="return-cancel-container">
        <h1 class="text-center mt-4 mb-4 fw-bold">Manage Return/Refund</h1>
        <!-- Button trigger modal -->

        <!-- Table for displaying category -->
        <table class="table table-bordered border-dark align-middle table-responsive">
            <thead class="text-center">
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Order No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Item</th>
                    <th scope="col">Image</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `return_refund` ORDER BY `date` DESC";
                $result = mysqli_query($con, $sql);
                //$number = 1; //pang increment
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rr_id = $row['rr_id'];
                        $placeOrder = $row['placeOrder'];
                        $custName = $row['custName'];
                        $item = $row['item'];
                        $image = $row['image'];
                        $qty = $row['qty'];
                        $reason = $row['reason'];
                        $status = $row['status'];
                        $date = $row['date'];
                        echo '<tr>
                    <th scope="row" class="text-center">' . $date . '</th>
                    <td class="text-center">' . $placeOrder . '</td>
                    <td class="text-center">' . $custName . '</td>
                    <td class="text-center">' . $item . '</td>
                    <td class="text-center"><img src="../images/' . $image . '" height="80" width="80" ></td>
                    <td class="text-center">' . $qty . '</td>
                    <td class="text-center">' . $reason. '</td>
                    <td class="text-center">' . $status. '</td>

                    <td class="text-center">
                        <div class="btn-group">
                            <button type="submit" class="update-btn btn btn-sm" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#updateReturn" 
                                data-update_return_id="' . $rr_id . '" data-update_status="' . $status . '">
                                    <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" class="delete-btn btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteReturn" 
                                data-delete-return_id=' . $rr_id . '>
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

<!-- Modal Content for updating return/refund-->
<div class="modal fade" id="updateReturn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="update-return_id" class="form-control" name="rr_id">
                    <div class="input-group mb-3">
                        <label for="update-status" class="input-group-text">Status:</label>
                        <select class="form-select" id="update-status" name="status">
                            <option value="pending" selected>Pending</option>
                            <option value="approved">Approved</option>
                            <option value="reject">Reject</option>
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

<!-- Modal Content for deleting return/refund-->
<div class="modal fade" id="deleteReturn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Query</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="delete-id" class="form-control" name="rr_id">
                    <div class="mb-3">
                        <p>Are you sure you want to delete?</p>
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
                const rr_id = edit.getAttribute('data-update_return_id');
                document.getElementById('update-return_id').value = rr_id;

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
                const rr_id = del.getAttribute('data-delete-return_id');
                document.getElementById('delete-id').value = rr_id;
            });
        });
    };
</script>