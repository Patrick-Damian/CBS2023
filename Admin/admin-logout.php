<?php

session_start();

if(isset($_SESSION['adminId']))
{
	unset($_SESSION['adminId']);

}

header("Location: admin-login.php");
die;