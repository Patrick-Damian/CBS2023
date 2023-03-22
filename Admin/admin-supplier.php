<?php
session_start();

include("../connection.php");
include("../functions.php");

$admin_data = check_login_admin($con);

// Function for adding supplier
if (isset($_POST['add'])) {
    $supp_name = $_POST['supp_name'];
    $category = $_POST['category'];
    $contact_no = $_POST['contact_no'];
    $city = $_POST['city'];

    $sql = "INSERT INTO `supplier` (`supp_name`,`category`,`contact_no`,`city`) VALUES ('$supp_name','$category','$contact_no','$city')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-supplier.php");
    } else {
        die(mysqli_error($con));
    }
}
if (isset($_POST['update'])) {
    $supp_id = $_POST['supp_id'];
    $supp_name = $_POST['supp_name'];
    $category = $_POST['category'];
    $contact_no = $_POST['contact_no'];
    $city = $_POST['city'];

    $sql = "UPDATE `supplier` set `supp_id`=$supp_id,`supp_name`='$supp_name',`category`='$category',`contact_no`='$contact_no',`city`='$city' where `supp_id`=$supp_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-supplier.php");
    } else {
        die(mysqli_error($con));
    }
}
// Function for deleting supplier
if (isset($_POST['deleteSupp'])) { //button name
    $supp_id = $_POST['supp_id'];

    $sql = "DELETE FROM `supplier` WHERE supp_id=$supp_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-supplier.php");
    } else {
        die(mysqli_error($con));
    }
}
?>
<?php include "admin-header.php"; ?>
<div class="admin-supplier">
    <div class="supplier-container">
        <h1 class="text-center mt-3 fw-bold">Supplier Informtion</h1>
        <div class="float-md-end mb-4">
            <button type="button" class="btn my-3" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#addCategory">Add Supplier</button>
        </div>

        <table class="table table-bordered border-dark align-middle table-responsive mt-4">
            <thead class="text-center">
                <tr>
                    <th scope="col">Supplier Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Contact No.</th>
                    <th scope="col">City</th>
                    <th scope="col" colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "Select * from `supplier`";
                $result = mysqli_query($con, $sql);
                $number = 1;
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $supp_id = $row['supp_id'];
                        $supp_name = $row['supp_name'];
                        $category = $row['category'];
                        $contact_no = $row['contact_no'];
                        $city = $row['city'];
                        echo '
                    <tr>
                        <td class="text-center">' . $supp_name . '</td>
                        <td class="text-center">' . $category . '</td>
                        <td class="text-center">' . $contact_no . '</td>
                        <td class="text-center">' . $city . '</td>
                        <td class="text-center"><button type="submit" class="update-btn btn btn-sm" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#orderSupplier" data-update_suppId="' . $supp_id . '" data-update_suppName="' . $supp_name . '" data-update_category="' . $category . '" data-update_contactNo="' . $contact_no . '" data-update_City="' . $city . '">Order Now</button></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="submit" class="update-btn btn btn-sm" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#updateSupplier" data-update_suppId="' . $supp_id . '" data-update_suppName="' . $supp_name . '" data-update_category="' . $category . '" data-update_contactNo="' . $contact_no . '" data-update_City="' . $city . '">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button type="button" class="delete-cod btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteSupplier" data-delete_suppId="' . $supp_id . '">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                ';
                        $number++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Content for ordering to supplier-->
<div class="modal fade" id="orderSupplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Order Supplies</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="update-suppId" class="form-control" name="supp_id">
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Supplier Name: </span>
                        <input type="text" id="update-suppName" class="form-control" name="supp_name">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Category: </span>
                        <input type="text" id="update-category" class="form-control" name="category">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Contact No.: </span>
                        <input type="text" id="update-contactNo" class="form-control" name="contact_no">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Date of Order </span>
                        <input type="date" class="form-control" name="date">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message:</label>
                        <textarea class="form-control" name="desc" aria-label="With textarea" rows="5"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn" style="background-color: #630000;color:#fff;" name="add">Send</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Content for adding sipplier-->
<div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Supplier Name: </span>
                        <input type="text" class="form-control" name="supp_name">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Category: </span>
                        <input type="text" class="form-control" name="category">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Contact No.: </span>
                        <input type="text" class="form-control" name="contact_no">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">City: </span>
                        <input type="text" class="form-control" name="city">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn" style="background-color: #630000;color:#fff;" name="add">Add Supplier</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Content for updating supplier-->
<div class="modal fade" id="updateSupplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="updated-suppId" class="form-control" name="supp_id">
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Supplier Name: </span>
                        <input type="text" id="updated-suppName" class="form-control" name="supp_name">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Category: </span>
                        <input type="text" id="updated-category" class="form-control" name="category">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Contact No.: </span>
                        <input type="text" id="updated-contactNo" class="form-control" name="contact_no">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">City: </span>
                        <input type="text" id="updated-city" class="form-control" name="city">
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
<div class="modal fade" id="deleteSupplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="delete-suppId" class="form-control" name="supp_id">
                    <div class="mb-3">
                        <p>Are you sure you want to delete this supplier?</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn" style="background-color: #630000;color:#fff;" name="deleteSupp">Delete</button>
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
                const suppId = edit.getAttribute('data-update_suppId');
                document.getElementById('updated-suppId').value = suppId;

                const suppName = edit.getAttribute('data-update_suppName');
                document.getElementById('updated-suppName').value = suppName;

                const category = edit.getAttribute('data-update_category');
                document.getElementById('updated-category').value = category;

                const contactNo = edit.getAttribute('data-update_contactNo');
                document.getElementById('updated-contactNo').value = contactNo;

                const city = edit.getAttribute('data-update_city');
                document.getElementById('updated-city').value = city;

            });
        });
    };
    const del_btn = document.querySelectorAll('.delete-cod');
    if (del_btn) {
        del_btn.forEach((del) => {
            del.addEventListener('click', () => {
                console.log('click');
                const supp_id = del.getAttribute('data-delete_suppId');
                document.getElementById('delete-suppId').value = supp_id;
            });
        });
    };
</script>