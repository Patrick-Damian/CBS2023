<?php
session_start();

include("../connection.php");
include("../functions.php");

$admin_data = check_login_admin($con);

?>

<table class="table table-bordered border-dark align-middle table-responsive my-5">
    <thead class="text-center">
        <tr>
            <th scope="col">Users ID</th>
            <th scope="col">Cart Id</th>
            <th scope="col">Username</th>   
            <th scope="col">Product</th>
            <th scope="col">price</th>
            <th scope="col">Image</th>
            <th scope="col">quantity</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $usersId = $_GET['usersId'];
        $sql = "SELECT usr.* ,cr.* FROM users usr, cart cr WHERE usersId=$usersId";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr class="p-3">
                <td><?php echo $row['usersId']?></td>
                <td><?php echo $row['cart_id']?></td>

                <td><?php echo $row['cart_name']?></td>
                <td><?php echo $row['price']?></td>
                <td><?php echo $row['image']?></td>
                <td><?php echo $row['quantity']?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<?php include "admin-footer.php"; ?>