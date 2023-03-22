<?php
session_start();

include("../connection.php");
include("../functions.php");

$admin_data = check_login_admin($con);

// Function for adding products
if (isset($_POST['add'])) {
    $prod_name = $_POST['prod_name'];
    $image = $_POST['image'];
    $img1 = $_POST['img1'];
    $img2 = $_POST['img2'];
    $desc = $_POST['desc'];
    $stock = $_POST['stock'];
    $code = $_POST['code'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $sql = "INSERT INTO `product_list` (`prod_name`,`image`,`img1`,`img2`,`desc`,`stock`,`code`,`price`,`category`) VALUES ('$prod_name','$image','$img1','$img2','$desc','$stock','$code','$price','$category')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-products.php");
    } else {
        die(mysqli_error($con));
    }
}
// Function for deleting products
if (isset($_POST['delete'])) { //button name
    $prod_id = $_POST['prod_id'];

    $sql = "Delete from `product_list` where prod_id=$prod_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-products.php");
    } else {
        die(mysqli_error($con));
    }
}

if (isset($_POST['update'])) {
    $prod_id = $_POST['prod_id'];
    $prod_name = $_POST['prod_name'];
    $image = $_POST['image'];
    $desc = $_POST['desc'];
    $stock = $_POST['stock'];
    $code = $_POST['code'];
    $price = $_POST['price'];

    $sql = "UPDATE `product_list` set `prod_id`=$prod_id,`prod_name`='$prod_name',`image`='$image',`desc`='$desc',`stock`='$stock',`code`='$code',`price`='$price' where `prod_id`=$prod_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-products.php");
    } else {
        die(mysqli_error($con));
    }
}

if (isset($_POST['update_inv'])) {
    $prod_id = $_POST['prod_id'];
    // $stocks_inv = $_POST['stocks_inv'];
    $sql = "SELECT * FROM `product_list` WHERE `prod_id`=$prod_id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $stocks_inv = $row['stock'] - 1;

    // if ($stocks_inv <= 15) {
    //     echo 'critical level';
    // }


    $sql_inv = "UPDATE `product_list` set `stock`='$stocks_inv' WHERE `prod_id`=$prod_id";
    $result_inv = mysqli_query($con, $sql_inv);
    if ($result_inv) {
        header("Location: admin-products.php");
    } else {
        die(mysqli_error($con));
    }



}
?>


<?php include "admin-header.php"; ?>
<div class="admin-products">
    <div class="products-container">
        <h1 class="text-center mt-4 fw-bold">Manage Products</h1>
        <!-- Button trigger modal -->
        <!-- Adding Products Button-->
        <div class="float-md-end mb-4">
            <button type="button" class="btn my-3" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#addProducts">Add Products</button><br>
        </div>
        <!-- Table for displaying products -->
        <table class="table table-bordered border-dark table-sm table align-middle">
            <thead class="text-center">
                <tr>
                    <!-- <th scope="col">ProductID</th> -->
                    <th scope="col">Product Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Description</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Code</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "Select * from `product_list`";
                $result = mysqli_query($con, $sql);
                $num = mysqli_num_rows($result);
                echo '<h4 class="fw-bold">Total Products: ' . $num . '</h4>';
                $numberPages = 8;
                $totalPages = ceil($num / $numberPages);
                // 
                //creating pagination
                for ($btn = 1; $btn <= $totalPages; $btn++) {
                    echo '
                        <a href="admin-products.php?page=' . $btn . '" class="btn fw-bold btn-sm text-light mt-3" style="background: #630000;border-radius:0;border:2px solid #fff;">' . $btn . '</a>
                    ';
                }
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $startinglimit = ($page - 1) * $numberPages;
                $sql = "Select * from `product_list` limit " . $startinglimit . ',' . $numberPages;
                $result = mysqli_query($con, $sql);
                //-------------------
                // $number = 1; //increment the product id
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $prod_id = $row['prod_id'];
                        $prod_name = $row['prod_name'];
                        $image = $row['image'];
                        $desc = $row['desc'];
                        $stock = $row['stock'];
                        $code = $row['code'];
                        $price = $row['price'];
                        $stocks_inv = $row['stock'] - 1;
                        echo '<tr>
                    <td class="text-center">' . $prod_name . '</td>
                    <td class="text-center"><img class="admin-products-image" src="../images/' . $image . '" height="80" width="80"></td>
                    <td style="width: 30rem;">' . $desc . '</td>
                    <td class="text-center">' . $stock . '</td>
                    <td class="text-center">' . $code . '</td>
                    <td class="text-center">₱' . $price . '</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="submit" class="update-btn btn btn-sm" style="background-color: #630000;color:#fff;" data-bs-toggle="modal" data-bs-target="#updateProducts" 
                                data-update_prod_id="' . $prod_id . '" data-update_prod_name="' . $prod_name . '" data-update_image="' . $image . '"
                                data-update_desc="' . $desc . '" data-update_stock="' . $stock . '" data-update_code="' . $code . '" data-update_price="' . $price . '">
                                    <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" class="delete-btn btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProducts" 
                                data-delete-product_id=' . $prod_id . '>
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                    </tr>';
                        // $number++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Content for adding products-->
<div class="modal fade" id="addProducts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">New Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category" class="form-label">Category:</label>
                        <input type="text" class="form-control" name="category" placeholder="Category">
                    </div>
                    <div class="mb-3">
                        <label for="prod_name" class="form-label">Product Name:</label>
                        <input type="text" class="form-control" name="prod_name" placeholder="Product Name">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image:</label><br>
                        <input type="file" class="form-control" id="inputGroupFile02" name="image">
                        <!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->
                    </div>
                    <div class="mb-3">
                        <label for="img1" class="form-label">Image1:</label><br>
                        <input type="file" class="form-control" id="inputGroupFile02" name="img1">
                        <!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->
                    </div>
                    <div class="mb-3">
                        <label for="img2" class="form-label">Image2:</label><br>
                        <input type="file" class="form-control" id="inputGroupFile02" name="img2">
                        <!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Description:</label>
                        <textarea class="form-control" name="desc" aria-label="With textarea" placeholder="Enter description" rows="5"></textarea>
                        <!-- <input type="message" class="form-control" name="desc" placeholder="Enter description" style="height: 100px; width: 465px;"> -->
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock:</label>
                        <input type="number" class="form-control" name="stock" placeholder="Enter stocks">
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Product Code:</label>
                        <input type="text" class="form-control" name="code" placeholder="Enter product code">
                    </div>

                    <label for="price" class="form-label">Price:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">₱</span>
                        <input type="text" class="form-control" name="price" placeholder="Enter price">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn" style="background-color: #630000;color:#fff;" name="add">Add Product</button>
                    <button type="button" class="btn btn-danger" style="background-color: #630000;color:#fff;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Content for updating products-->
<div class="modal fade" id="updateProducts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Update Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="update-prod_id" class="form-control" name="prod_id">
                    <div class="mb-3">
                        <label for="prod_name" class="form-label">Product Name:</label>
                        <input type="text" id="update-prod_name" class="form-control" name="prod_name" placeholder="Product Name">
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image:</label><br>
                        <input type="text" id="update-image" class="form-control" id="inputGroupFile02" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Description:</label>
                        <textarea class="form-control" id="update-desc" name="desc" aria-label="With textarea" rows="5"></textarea>
                        <!-- <input type="message" id="update-desc" class="form-control" name="desc" placeholder="Enter description" style="height: 100px; width: 465px;"> -->
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock:</label>
                        <input type="text" id="update-stock" class="form-control" name="stock" placeholder="Enter stocks">
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Product Code:</label>
                        <input type="text" id="update-code" class="form-control" name="code" placeholder="Enter product code">
                    </div>

                    <label for="price" class="form-label">Price:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">₱</span>
                        <input type="text" id="update-price" class="form-control" name="price" placeholder="Enter price">
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

<!-- Modal Content for deleting products-->
<div class="modal fade" id="deleteProducts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Delete Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="delete-id" class="form-control" name="prod_id">
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
                const prod_id = edit.getAttribute('data-update_prod_id');
                document.getElementById('update-prod_id').value = prod_id;

                const prod_name = edit.getAttribute('data-update_prod_name');
                document.getElementById('update-prod_name').value = prod_name;

                const images = edit.getAttribute('data-update_image');
                document.getElementById('update-image').value = images;

                const desc = edit.getAttribute('data-update_desc');
                document.getElementById('update-desc').value = desc;

                const stock = edit.getAttribute('data-update_stock');
                document.getElementById('update-stock').value = stock;

                const code = edit.getAttribute('data-update_code');
                document.getElementById('update-code').value = code;

                const price = edit.getAttribute('data-update_price');
                document.getElementById('update-price').value = price;
            });
        });
    };
    const del_btn = document.querySelectorAll('.delete-btn');
    if (del_btn) {
        del_btn.forEach((del) => {
            del.addEventListener('click', () => {
                console.log('click');
                const prod_id = del.getAttribute('data-delete-product_id');
                document.getElementById('delete-id').value = prod_id;
            });
        });
    };
</script>