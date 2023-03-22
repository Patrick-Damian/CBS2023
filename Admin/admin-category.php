<?php
session_start();

include("../connection.php");
include("../functions.php");

$admin_data = check_login_admin($con);

// Function for adding products
if (isset($_POST['add'])) {
    $cat_name = $_POST['cat_name'];

    $sql = "INSERT INTO `category` (`cat_name`) VALUES ('$cat_name')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-category.php");
    } else {
        die(mysqli_error($con));
    }
}
// Function for deleting products
if (isset($_POST['delete'])) { //button name
    $cat_id = $_POST['cat_id'];

    $sql = "Delete from `category` where cat_id=$cat_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-category.php");
    } else {
        die(mysqli_error($con));
    }
}

if (isset($_POST['update'])) {
    $cat_id = $_POST['cat_id'];
    $cat_name = $_POST['cat_name'];

    $sql = "UPDATE `category` set `cat_id`=$cat_id,`cat_name`='$cat_name' where `cat_id`=$cat_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-category.php");
    } else {
        die(mysqli_error($con));
    }
}
?>
<?php include "admin-header.php"; ?>
<div class="admin-category">
    <div class="category-container">
        <h1 class="text-center mt-4 fw-bold">Manage Categories</h1>
        <!-- Button trigger modal -->
        <!-- Adding Category Button-->
        <div class="float-md-end mb-4">
            <button type="button" class="btn my-3" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#addCategory">Add Category</button>
        </div>
        <!-- Table for displaying category -->
        <table class="table table-bordered border-dark align-middle table-responsive">
            <thead class="text-center">
                <tr>
                    <th scope="col">Category ID</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "Select * from `category`";
                $result = mysqli_query($con, $sql);
                $number = 1;
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $cat_id = $row['cat_id'];
                        $cat_name = $row['cat_name'];
                        echo '<tr>
                    <th scope="row" class="text-center">' . $number . '</th>
                    <td class="text-center">' . $cat_name . '</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="submit" class="update-btn btn btn-sm" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#updateCategory" 
                                data-update_cat_id="' . $cat_id . '" data-update_cat_name="' . $cat_name . '">
                                    <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" class="delete-btn btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCategory" 
                                data-delete-cat_id=' . $cat_id . '>
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

<!-- Modal Content for adding category-->
<div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cat_name" class="form-label">Category Name:</label>
                        <input type="text" class="form-control" name="cat_name" placeholder="Category Name">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn" style="background-color: #630000;color:#fff;" name="add">Add Category</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Content for updating category-->
<div class="modal fade" id="updateCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="update-cat_id" class="form-control" name="cat_id">
                    <div class="mb-3">
                        <label for="cat_name" class="form-label">Category Name:</label>
                        <input type="text" id="update-cat_name" class="form-control" name="cat_name" placeholder="Category Name">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn" style="background-color: #630000;color:#fff;" name="update">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Content for deleting category-->
<div class="modal fade" id="deleteCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="delete-id" class="form-control" name="cat_id">
                    <div class="mb-3">
                        <p>Are you sure you want to delete this product?</p>
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
                const cat_id = edit.getAttribute('data-update_cat_id');
                document.getElementById('update-cat_id').value = cat_id;

                const cat_name = edit.getAttribute('data-update_cat_name');
                document.getElementById('update-cat_name').value = cat_name;
            });
        });
    };
    const del_btn = document.querySelectorAll('.delete-btn');
    if (del_btn) {
        del_btn.forEach((del) => {
            del.addEventListener('click', () => {
                console.log('click');
                const cat_id = del.getAttribute('data-delete-cat_id');
                document.getElementById('delete-id').value = cat_id;
            });
        });
    };
</script>