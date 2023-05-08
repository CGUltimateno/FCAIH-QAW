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
        $stmt = mysqli_stmt_init($conn);
        
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
    
    $stmt = mysqli_stmt_init($conn);
                    
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
    mysqli_close($conn);
    
}

}
