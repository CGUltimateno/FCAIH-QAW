<?php
session_start();
define("TITLE", "discussio");
include_once ('inc/dbh.inc.php');
function strip_bad_chars( $input ){
    $output = preg_replace( "/[^a-zA-Z0-9_-]/", "", $input);
    return $output;
}
if(isset($_SESSION['id']))
{
    header("Location: index.php");
    exit();
}

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

  // Check if the username and password are valid
  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = $db->query($sql);
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
    $error= "<p class='error'>Invalid Username or Password</p>";
  }
  }
}
?>
<!DOCTYPE html>
<html lang="en_us">
<head>
    <meta charset="UTF-8">
    <title>Discussio</title>
    <link rel="stylesheet" type="text/css" href="css/login3.css">
    <link rel="shortcut icon" href="image/favicon.png" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
<div class="container">
    <div class="image">
        <img src='image/400.png'>
    </div>
    <div class="login-box">
        <h2>Discussio</h2>
        <form method="post">
            <?php if (!empty($error)) {
                echo $error;
            } ?>
            <div class="form-group">
                <input type="text" class="form-control form-control-lg mr-1" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <input type="password" class="form-control form-control-lg mr-1" name="password" placeholder="Password">
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-light btn-lg" name="register_btn"><a href="signup.php">Sign Up</a></button>
                <button type="submit" class="btn btn-dark btn-lg" name="login_btn">Login</button>
            </div>
        </form>
    </div>
</div>
</body>

</html>


