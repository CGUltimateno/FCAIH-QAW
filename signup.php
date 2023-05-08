<?php
	session_start();
require "languages/lang.php";
require_once ('inc/dbh.inc.php');
if(isset($_SESSION['id']))
{
    header("Location: index.php");
    exit();
}

	// initialize variables
	$username = "";
	$email    = "";
    $f_name = "";
    $l_name = "";
    $gender = "";
    $bio = "";
    $errors = array();

	// register user
	if (isset($_POST['register_btn'])) {
        // receive all input values from the form
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $f_name = mysqli_real_escape_string($db, $_POST['f_name']);
        $l_name = mysqli_real_escape_string($db, $_POST['l_name']);
        $gender = mysqli_real_escape_string($db, $_POST['gender']);
        $bio = mysqli_real_escape_string($db, $_POST['bio']);
        $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

        // form validation
        if (empty($username)) {
            $errors[] = "Username is required";
        }
        if (empty($email)) {
            $errors[] = "Email is required";
        }
        if (empty($password_1)) {
            $errors[] = "Password is required";
        }
        if ($password_1 != $password_2) {
            $errors[] = "The two passwords do not match";
        }

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        $imageData = file_get_contents($target_file);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (isset($_POST["register_btn"])) {
            $check = getimagesize($_FILES["img"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $errors[] = "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $errors[] = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $errors[] = "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                $image_path = mysqli_real_escape_string($db, $target_file);
                $query = "INSERT INTO users (username, email, password, f_name, l_name, gender, bio, img) VALUES('$username', '$email', '$password_1', '$f_name', '$l_name', '$gender', '$bio', '$image_path')";
                mysqli_query($db, $query);
                $_SESSION['username'] = $username;
                $success = "<p class='success'>Signup Successful </p>";
                header("Location: index.php");
                exit;
            } else {
                $errors[] = "Sorry, there was an error uploading your file.";
            }
        }
    }

?>
<!DOCTYPE html>
<html>
<html lang="en_us">
<head>
    <meta charset="UTF-8">
    <title>Discussio</title>
    <link rel="stylesheet" type="text/css" href="css/signup2.css">
    <link rel="shortcut icon" href="image/favicon.png" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="background-color: rgba(255, 255, 255, 0.8);">
                <div class="card-body">
                    <div class="d-flex justify-content-center mb-3">
                        <img src="image/400.png">
                    </div>
                    <h2 class="text-center mb-3">Sign Up</h2>
                    <form action="signup.php"  method="post" enctype="multipart/form-data">
                        <?php include('errors.php'); ?>
                        <?php if (!empty($success)) {  echo $success ; } ?>
                        <div class="text-center">
                            <div class="mb-3">
                                <img id="blah" class="rounded" src="#" alt="your image" class="img-responsive rounded"
                                     style="height: 200px; width: 190px; object-fit: cover;">
                                <br><br><label class="btn btn-primary ">
                                    Set Avatar <input type="file" id="imgInp" name='img' hidden>
                                </label>
                            </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" >
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" >
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password_1" class="form-control" placeholder="Password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_2" class="form-control" placeholder="Confirm Password">
                        </div>
                            <div class="mb-3 row">
                                <div class="col">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="f_name" class="form-control" placeholder="First Name">
                                </div>
                                <div class="col">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="l_name" class="form-control" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form-group col">
                                <label >Gender</label><br>
                                <input id="toggle-on" class="toggle toggle-left" name="gender" value="m" type="radio" checked>
                                <label for="toggle-on" class="btn-r">M</label>
                                <input id="toggle-off" class="toggle toggle-right" name="gender" value="f" type="radio">
                                <label for="toggle-off" class="btn-r">F</label>
                            </div>
                            <div class="form-group">
                                <label for="bio">Bio</label>
                                <textarea class="form-control" id="bio" name="bio" rows="6" maxlength="1000"
                                          placeholder="Tell people about yourself"></textarea>
                            </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100" name="register_btn">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>
<script>
    $(document).ready(function() {
        $('#blah').attr('src', 'uploads/default.png');
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });
    });
</script>
</body>
</html>