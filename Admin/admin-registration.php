<?php
session_start();

include("../connection.php");
include("../functions.php");

$admin_data = check_login_admin($con);

// Function for adding adminn
if (isset($_POST['add'])) {
    $admin_name = $_POST['username'];
    $admin_password = md5 ($_POST['password']);

    $sql = "INSERT INTO `admin_user` (`admin_name`,`admin_password`) VALUES ('$admin_name','$admin_password')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-registration.php");
    } else {
        die(mysqli_error($con));
    }
}
// Function for updating admin
if (isset($_POST['update'])) {
    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['username'];
    $admin_password = md5 ($_POST['password']);

    $sql = "UPDATE `admin_user` SET `adminId`=$admin_id,`admin_name`='$admin_name',`admin_password`='$admin_password' WHERE `adminId`=$admin_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-registration.php");
    } else {
        die(mysqli_error($con));
    }
}

// Function for deleting admin
if (isset($_POST['delete'])) { //button name
    $adminId = $_POST['adminId'];

    $sql = "Delete from `admin_user` where adminId=$adminId";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-registration.php");
    } else {
        die(mysqli_error($con));
    }
}
?>
<?php include "admin-header.php"; ?>
<div class="admin-registration">
    <div class=registration-container">
        <h1 class="text-center mt-4 fw-bold">Manage Admins</h1>
        <!-- Button trigger modal -->
        <!-- Adding Category Button-->
        <div class="float-md-end mb-4">
            <button type="button" class="btn my-3" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#addAdmin">Add Admin</button>
        </div>
        <!-- Table for displaying admins -->
        <table class="table table-bordered border-dark align-middle table-responsive">
            <thead class="text-center">
                <tr>
                    <th scope="col">Admin ID</th>
                    <th scope="col">Admin Name</th>
                    <th scope="col">Date Added</th>
                    <th scope="col" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `admin_user` ORDER BY `date` DESC;";
                $result = mysqli_query($con, $sql);
                $number = 1;
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $adminId = $row['adminId'];
                        $admin_name = $row['admin_name'];
                        $admin_password = $row['admin_password'];
                        $date = $row['date'];
                        echo '<tr>
                        <td class="text-center">' . $number . '</td>
                        <td class="text-center">' . $admin_name . '</td>
                        <td class="text-center">' . $date . '</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="submit" class="update-btn btn btn-sm" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#updateAdmin" 
                                    data-update_adminId="' . $adminId . '" data-update_adminName="' . $admin_name . '" data-update_password="' . $admin_password . '" data-update_conpassword="' . $admin_password . '">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button type="button" class="delete-btn btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAdmin" 
                                    data-delete-adminId=' . $adminId . '>
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                        </tr>';
                        $number++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Content for adding admin-->
<div class="modal fade" id="addAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Add New Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Admin username: </span>
                        <input type="text" class="form-control" placeholder="Enter username" name="username">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Password: </span>
                        <input type="password" class="form-control" placeholder="Enter password" name="password">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Confirm Password: </span>
                        <input type="password" class="form-control" placeholder="Confirm Password">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn" style="background-color: #630000;color:#fff;" name="add">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Content for updating admin-->
<div class="modal fade" id="updateAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Update Admin Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="update-adminId" class="form-control" name="admin_id">
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Admin username: </span>
                        <input type="text" id="update-adminName" class="form-control" name="username">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Password: </span>
                        <input type="password" id="update-password" class="form-control" name="password">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #630000;color:#fff;">Confirm Password: </span>
                        <input type="password" id="update-conpassword" class="form-control">
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
<!-- Modal Content for deleting admin-->
<div class="modal fade" id="deleteAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Delete Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="delete-id" class="form-control" name="adminId">
                    <div class="mb-3">
                        <p>Are you sure you want to delete this Admin?</p>
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
<?php include "admin-footer.php"; ?>
<script>
    const update_btn = document.querySelectorAll('.update-btn');
    if (update_btn) {
        update_btn.forEach((edit) => {
            edit.addEventListener('click', () => {
                console.log('click');
                const admin_id = edit.getAttribute('data-update_adminId');
                document.getElementById('update-adminId').value = admin_id;

                const admin_name = edit.getAttribute('data-update_adminName');
                document.getElementById('update-adminName').value = admin_name;

                const admin_password = edit.getAttribute('data-update_password');
                document.getElementById('update-password').value = admin_password;

                const admin_conpassword = edit.getAttribute('data-update_conpassword');
                document.getElementById('update-conpassword').value = admin_conpassword;
            });
        });
    };
    const del_btn = document.querySelectorAll('.delete-btn');
    if (del_btn) {
        del_btn.forEach((del) => {
            del.addEventListener('click', () => {
                console.log('click');
                const admin_id = del.getAttribute('data-delete-adminId');
                document.getElementById('delete-id').value = admin_id;
            });
        });
    };
</script>