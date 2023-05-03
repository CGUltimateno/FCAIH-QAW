<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if(empty($username)){
    $error="<p class='error'>Username is required </p>";
  }
  elseif(empty($password)){
     $error="<p class='error'>Password is required </p>";
  }
  else{

  // Connect to the database
  $db_host = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "database";
  $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  // Check if the username and password are valid
  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result);
  if ($result->num_rows == 1) {
    // Login successful, set session variables
    $_SESSION['loggedin'] = true;
    
    $_SESSION['id'] = $row ['id'];
    $_SESSION['username'] = $row ['username'];
                    
    $_SESSION['email'] = $row ['email'];
    $_SESSION['f_name'] = $row ['f_name'];
    $_SESSION['l_name'] = $row ['l_name'];
     $_SESSION['gender'] = $row ['gender'];
      $_SESSION['bio'] = $row ['bio'];
      $_SESSION['reputation'] = $row ['reputation'];
      $_SESSION['img'] = $row ['img'];
                
          
                    if($_SESSION['username']=='admin'){
                        header("Location: Admin.php");
                    }
                    else{
                    header("Location: profile.php");
                    exit();
                    }
                
               
    

  } else  {
    // Login failed, show error message
    $error= "<p class='error'>Invalid Username or Password</p>";
    
             }
       }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="login3.css">
  </head>
  <body>
  <div class= "image">
  <img src='img/200.png'>
  </div>
    <div class="login-box">
      <h2>Login Here</h2>
      <form  method="post" >
      <?php if (!empty($error)) {  echo $error ; } ?>
      <div class="input-group">
			<label>Username</label>
			<input type="text" name="username" placeholder="Username" >
	  </div>
      <div class="input-group">
			<label>Password</label>
			<input type="password" name="password" placeholder="Password">
	  </div>
        <button type="submit" class="btn" name="register_btn"><a href="signup.php">Sign Up</a></button>
        <button type="submit" class="btn1" name="submit">Login</button>
      </form>
    </div>
  </body>
</html>


