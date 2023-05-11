<?php
session_start();

if (isset($_REQUEST['update-profile']))
{
    
    require 'dbh.inc.php';
    
    $username=$_SESSION['username'];
    $id=$_SESSION['id'];
    $email = $_REQUEST['email'];
    $f_name = $_REQUEST['f-name'];
    $l_name = $_REQUEST['l-name'];
    
    $password = $_REQUEST['pwd'];
    
    $gender = $_REQUEST['gender'];
    $bio = $_REQUEST['bio'];


    if(isset($_FILES['img'])) {
        // Check if file was uploaded without errors
        if (isset($_FILES["img"]) && $_FILES["img"]["error"] == 0) {
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
            $filename = $_FILES["img"]["name"];
            $filetype = $_FILES["img"]["type"];
            $filesize = $_FILES["img"]["size"];

            // Verify file extension
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["img"]["name"]);
            $imageData = file_get_contents($target_file);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (isset($_POST["update-profile"])) {
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
                    $sql = "UPDATE users SET img='$image_path' WHERE id=" . $_SESSION['id'];
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        $_SESSION['img'] = $filename;
                    }
                } else {
                    echo "Error: There was a problem uploading your file. Please try again.";
                }
            }
        }
    }
    
    if (empty($email))
    {
        header("Location: ../edit.php?error=emptyemail");
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        header("Location: ../edit.php?error=invalidmail");
        exit();
    }
    else
    {
        $sql = "SELECT * FROM users WHERE username=?;";
        $stmt = mysqli_stmt_init($db);
        
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../edit.php?error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
            mysqli_stmt_execute($stmt);

            
            $result = mysqli_stmt_get_result($stmt);

             if(empty($password)) {$pwdChange=false; }
             else {$pwdChange=true;  }    


             $FileNameNew = $_SESSION['img'];
               require 'upload.inc.php';


            $sql = "UPDATE users "
            . "SET f_name=?, "
            . "l_name=?, "
            . "email=?, "
            . "gender=?, "
            . "bio=?, "
            . "img=? ";
    
        
            if ($pwdChange)
            {
                $sql .= ", password=? "
                        . "WHERE username=?;";
            }
            else
            {
                $sql .= "WHERE username=?;";
            }
    
    $stmt = mysqli_stmt_init($db);
                    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../edit.php?error=sqlerror");
        exit();
    }
    else
    {
        
            
        if ($pwdChange)
        {
            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssssssss", $f_name, $l_name, $email,
                $gender,  $bio, 
                $FileNameNew, $password, $_SESSION['username']);
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "sssssss", $f_name, $l_name, $email,
                $gender, $bio, 
                $FileNameNew, $_SESSION['username']);
        }
        
            
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        

        $_SESSION['email'] = $email;
        $_SESSION['f_name'] = $f_name;
        $_SESSION['l_name'] = $l_name;
        $_SESSION['gender'] = $gender;
        $_SESSION['password'] =$password ;
        $_SESSION['bio'] = $bio;
        $_SESSION['img'] = $FileNameNew;

        header("Location: ../edit.php?edit=success");
        exit();
    }

}
              
                    
                    
        
    
    mysqli_stmt_close($stmt);
    mysqli_close($db);
    
}

}
