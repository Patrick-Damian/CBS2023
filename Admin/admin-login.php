<?php
session_start();

include("../connection.php");
include("../functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	//something was posted
	$admin_name = $_POST['admin_name'];
	$admin_password = md5($_POST['admin_password']);

	if (!empty($admin_name) && !empty($admin_password)) {
		//read from database
		$query = "select * from admin_user where admin_name = '$admin_name'";
		$result = mysqli_query($con, $query);

		if ($result) {
			if ($result && mysqli_num_rows($result) > 0) {
				$admin_data = mysqli_fetch_assoc($result);
				if ($admin_data['admin_password'] === $admin_password) {
					$_SESSION['adminId'] = $admin_data['adminId'];
					header("Location: admin-index.php?status=success"); //nagbago
					die;
				}
			}
		}
		echo '<script>alert("Incorrect username or password")</script>';
		// header("Location: admin-login.php?status=failed");
	} else {
		header("Location: admin-login.php");
		// echo "Successfully Login";
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/admin-style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<title>CBS || Admin Panel</title>
</head>

<body>
	<div class="admin-login">
		<form method="post">
			<div class="login">
				<h4 class="text-center text-white">Login as Admin</h4>
				<p class="mt-3 mb-3 text-white">Please login your account</p>

				<div class="input-group mb-3">
					<span class="input-group-text" style="background: #E6E6E6;">Username:</span>
					<input type="text" class="form-control" placeholder="Enter your Username" name="admin_name" id="username" required>
				</div>
				<!-- <label class="label-login" for="admin_name">Username:</label>
				<input type="text" placeholder="Enter your Username" name="admin_name" id="username" required><br> -->

				<div class="input-group mb-3">
					<span class="input-group-text" style="background: #E6E6E6;">Password:</span>
					<input type="password" class="form-control" placeholder="Enter your Password" name="admin_password" id="password" required>
				</div>

				<!-- <label class="label-login" for="admin_password">Password:</label>
				<input type="password" placeholder="Enter your Password" name="admin_password" id="password" required><br> -->

				<div class="d-grid gap-2 col-6 mx-auto">
					<button name="submit" type="submit" class="btn" style="background: #E6E6E6;">Login</button>
				</div>
				<!-- <p class="text-center mt-3 text-white">Don't have an account? <a href="admin-register.php">Register here</a></p> -->
				<!-- <p class="login-link">Back to Home page? <a href="../index.php">Home Page</a></p> -->
			</div>
		</form>
	</div>
</body>

</html>