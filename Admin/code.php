<?php
session_start();

include("../connection.php");
include("../functions.php");

$admin_data = check_login_admin($con);

if (isset($_POST['search_data'])) {
    $id = $_POST['id'];
    $visible = $_POST['visible'];

    $query = "UPDATE user_order SET visible='$visible' WHERE id='$id'";
    $query_run = mysqli_query($con, $query);
}
?>
