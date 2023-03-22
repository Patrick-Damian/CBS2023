<?php

session_start();

if(isset($_SESSION['usersId']))
{
	unset($_SESSION['usersId']);

}

header("Location: login.php");
die;