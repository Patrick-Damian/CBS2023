<?php

function check_login($con)
{

	if(isset($_SESSION['usersId']))
	{

		$id = $_SESSION['usersId'];
		$query = "select * from users where usersId = '$id' limit 1";

		$result = mysqli_query($con,$query);
		if($result && mysqli_num_rows($result) > 0)
		{

			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}

	//redirect to login
	// header("Location: index.php");
	// die;
}
function check_login_admin($con)
{

	if(isset($_SESSION['adminId']))
	{

		$id = $_SESSION['adminId'];
		$query = "select * from admin_user where adminId = '$id' limit 1";

		$result = mysqli_query($con,$query);
		if($result && mysqli_num_rows($result) > 0)
		{

			$admin_data = mysqli_fetch_assoc($result);
			return $admin_data;
		}
	}

	//redirect to login
	header("Location: admin-login.php");
	die;
}