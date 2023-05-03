<?php
	session_start();

	// connect to the database
	$db = mysqli_connect('localhost', 'root','', 'database');

	// initialize variables
	$username = "";
	$email    = "";
	$errors = array();

	// register user
	if (isset($_POST['register_btn'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// form validation
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }
		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}
		if (count($errors) == 0) {
			$password = $password_1; // encrypt password before storing in database (not recommended for production)
			$query = "INSERT INTO users (username, email, password) VALUES('$username', '$email', '$password')";
			mysqli_query($db, $query);
			$_SESSION['username'] = $username;
			$success= "<p class='success'>Signup Successful </p>";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
	<link rel="stylesheet" type="text/css" href="signup2.css">
</head>
<body>
  <div class= "image">
   <img src='200.png'>
  </div>
	<div class="signup-form">
		<h2>Sign Up</h2>
		<form action="signup.php" method="post">
		<?php include('errors.php'); ?>
		<?php if (!empty($success)) {  echo $success ; } ?>
        <div class="input-group">
			<label>Username</label>
			<input type="text" name="username" placeholder="Username" >
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="email" name="email" placeholder="Email" >
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password_1" placeholder="Password">
		</div>
		<div class="input-group">
			<label>Confirm Password</label>
			<input type="password" name="password_2" placeholder="Confirm Password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="register_btn">Sign Up</button>
		</div>
		</form>
	</div>
</body>
</html>