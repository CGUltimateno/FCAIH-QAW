<?php
session_start();
if (isset($_POST['create-comm']))
{

    require 'dbh.inc.php';

    $commtitle = $_POST['comm-title'];
    $postContent = $_POST['post-content'];

    if (empty($topicSubject) || empty($postContent))
    {
        header("Location: ../create-topic.php?error=emptyfields");
        exit();
    }
    else
    {
        $sql = "insert into communities(comm_id, name, description) "
            . "values (?,now(),?,?)";
        $stmt = mysqli_stmt_init($db);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../create-topic.php?error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "sss", $commtitle,  $_SESSION['id']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $commtitle = mysqli_insert_id($db);

            $sql = "insert into questions(body, created_at, title, user_id) "
                . "values (?,now(),?,?)";
            $stmt = mysqli_stmt_init($db);

            if (!mysqli_stmt_prepare($stmt, $sql))
            {
                header("Location: ../create-topic.php?error=sqlerror");
                exit();
            }
            else
            {
                mysqli_stmt_bind_param($stmt, "sss", $body, $title, $_SESSION['id']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                header("Location: ../create-topic.php?operation=success");
            }
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($db);

}

else
{
    header("Location: ../index.php");
    exit();
}