<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

    $cartid = $_GET['deleteId'];

    $sql="DELETE FROM `carts` WHERE cart_id = '$cartid'";
    $result = $con->query($sql);

     if($result){
        header("location:cart.php");
     }
?>