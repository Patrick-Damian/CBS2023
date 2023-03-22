<?php 
session_start();

	include("../connection.php");
	include("../functions.php");

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$admin_name = $_POST['admin_name'];
		$admin_password = md5 ($_POST['admin_password']);

        $sql=mysqli_query($con,"SELECT * FROM admin_user where admin_name='$admin_name'");
        if(mysqli_num_rows($sql)>0)
        {
            // echo '<script>alert("Username already exists")</script>';
            header("Location: admin-register.php?status=failed");
            exit;
        }
        
		if(!empty($admin_name) && !empty($admin_password))
		{

			$query = "INSERT INTO admin_user (admin_name,admin_password) VALUES ('$admin_name','$admin_password')";

			mysqli_query($con, $query);

			header("Location: admin-login.php?status=success");
			die;
		}
		else
		{
			echo "Please enter some valid information!";
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
	<div class="admin-register">
		<form method="post">
			<div class="register">
				<h4 class="text-center text-white">Register as Admin</h4>
				<p class="mt-3 mb-3 text-white">Please fill in this form to create an account.</p>

				<div class="input-group mb-3">
					<span class="input-group-text" style="background: #E6E6E6;">Username:</span>
					<input type="text" class="form-control" placeholder="Enter your Username" name="admin_name" id="username" required>
				</div>

				<div class="input-group mb-3">
					<span class="input-group-text" style="background: #E6E6E6;">Password:</span>
					<input type="password" class="form-control" placeholder="Enter your Password" name="admin_password" id="password" required>
				</div>

                <div class="input-group mb-3">
					<span class="input-group-text" style="background: #E6E6E6;">Confirm Password:</span>
					<input type="password" class="form-control" name="admin_confirm_password" placeholder="Confirm Password" required>
				</div>

				<div class="d-grid gap-2 col-6 mx-auto">
					<button name="submit" type="submit" class="btn" style="background: #E6E6E6;">Register</button>
				</div>
                <p class="text-center mt-3 text-white">Already have an account? <a href="admin-login.php">Login</a></p>
			</div>
		</form>
	</div>
</body>

</html>

    <!-- <section class="admin-register">
        <form method="post">
            <div class="register">
                <h2 class="register-header">Register Here</h2>
                <h4>Please fill in this form to create an account.</h4>

                <label class="label-register" for="admin_name">Username:</label>
                <input id="text" type="text" name="admin_name" placeholder="Enter Username" required style="margin-left:3.8rem;"><br>

                <label class="label-register" for="admin_password">Password:</label>
                <input id="text" type="password" name="admin_password" placeholder="Password" required style="margin-left:4rem;"><br>

                <label class="label-register" for="admin_confirm_password">Confirm Password:</label>
                <input id="text" type="password" name="admin_confirm_password" placeholder="Confirm Password" required>

                <button type="submit" class="registerbtn">Register</button>

                <p class="login-link">Already have an account? <a href="admin-login.php">Login</a></p>
            </div> -->
            
            <!-- <div class="register-login">
                <p class="login-link">Back to Home page? <a href="index.php">Home Page</a></p>
            </div> -->
        <!-- </form>
    </section> -->

