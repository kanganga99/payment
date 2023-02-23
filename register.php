<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$msg = "";
include('./db_connect.php');
ob_start();
// if(!isset($_SESSION['system'])){
$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
foreach ($system as $k => $v) {
	$_SESSION['system'][$k] = $v;
}
// }
ob_end_flush();
?>
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title><?php echo $_SESSION['system']['name'] ?></title>
	<?php include('./header.php'); ?>
	<?php
	if (isset($_SESSION['login_id'])) {
		header("location:index.php?page=home");
	}
	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$cpassowrd = md5($_POST['cpassword']);

		if ($password != $cpassword)
			$msg = "Please check your password";
		else {
			$sql = "SELECT * FROM users WHERE username='$username'";
			$result = mysqli_query($conn, $sql);
			if (!$result->num_rows > 0) {
				$query = mysqli_query($conn, "INSERT INTO users (name,username,password)VALUES ('$name','$username','$password')");
				if ($query) {

					header("Location: register.php?success=User Registered succesfully");
					//  header("Location: home/");
					$name = "";
					$username = "";
					$_POST['password'] = "";
					$_POST['cpassword'] = "";
				} 
				else {
					header("Location: register.php?error=Something went wrong");
				}
			}
		}
	}
	?>
</head>
<style>
	body {
		width: 100%;
		height: calc(100%);
		position: fixed;
		top: 0;
		left: 0
			/*background: #007bff;*/
	}

	main#main {
		width: 100%;
		height: calc(100%);
		display: flex;
	}
</style>

<body class="bg-dark">
	<main id="main">
		<div class="align-self-center w-100">
			<h4 class="text-white text-center"><b><?php echo $_SESSION['system']['name'] ?></b></h4>
			<div id="login-center" class="bg-dark row justify-content-center">
				<div class="card col-md-4">
					<div class="card-body">
						<form id="login-form">
							<div class="form-group">
								<label for="name" class="control-label">Name</label>
								<input type="text" id="name" name="name" class="form-control">
							</div>
							<div class="form-group">
								<label for="username" class="control-label">Username</label>
								<input type="text" id="username" name="username" class="form-control">
							</div>
							<div class="form-group">
								<label for="password" class="control-label">Password</label>
								<input type="password" id="password" name="password" class="form-control">
							</div>
							<div class="form-group">
								<label for="cpassword" class="control-label">Confirm Password</label>
								<input type="password" id="cpassword" name="cpassword" class="form-control">
							</div>
							<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary" name="submit">Submit</button></center>
							<p class="login-register-text">Have an account? <a href="login.php">Login Here</a>.</p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</main>
	<!-- <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a> -->
</body>
</html>