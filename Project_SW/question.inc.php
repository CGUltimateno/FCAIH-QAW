<?php
session_start();
if (isset($_POST['question']))
{
    
    require 'dbh.inc.php';
    
    $topicSubject = $_POST['title'];
    $topicCategory = $_POST['cat_id'];
    $postContent = $_POST['body'];
    
    if (empty($topicSubject) || empty($postContent))
    {
        header("Location: ../question.php?error=emptyfields");
        exit();
    }
    else
    {
        $sql = "insert into questions(title, created_at, cat_id , user_id) "
                . "values (?,now(),?,?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../question.php?error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "sss", $topicSubject, $topicCategory,$_SESSION['userId']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            $topicid = mysqli_insert_id($conn);
            
            $sql = "insert into answers(body, created_at, question_id , user_id) "
                    . "values (?,now(),?,?)";
            $stmt = mysqli_stmt_init($conn);
            
            if (!mysqli_stmt_prepare($stmt, $sql))
            {
                header("Location: ../question.php?error=sqlerror");
                exit();
            }
            else
            {
                mysqli_stmt_bind_param($stmt, "sss", $postContent, $topicid,$_SESSION['userId']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                
                header("Location: ../question.php?operation=success");
            }
        }
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
}

else
{
    header("Location: ../index.php");
    exit();
}