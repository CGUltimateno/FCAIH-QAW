<?php

session_start();

if (isset($_GET['post']) && isset($_GET['vote']) && isset($_SESSION['id']))
{
    require 'dbh.inc.php';

    $post = $_GET['post'];
    $vote = $_GET['vote'];

    $sql = "SELECT user_id, type FROM votes WHERE question_id=? AND user_id=?";
    $stmt = mysqli_stmt_init($db);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: posts.php?topic=".$topic."&error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "ss", $post, $_SESSION['id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $resultCheck = mysqli_stmt_num_rows($stmt);

        if ($resultCheck > 0)
        {
            header("Location: posts.php?topic=".$topic."&error=voteexists");
            exit();
        }
    }

    $sql = "INSERT INTO votes (question_id, user_id, type) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($db);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: posts.php?topic=".$topic."&error=sqlerror");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "sss", $post, $_SESSION['id'], $vote);
        mysqli_stmt_execute($stmt);
        header("Location: posts.php?topic=".$topic);
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($db);
}

else
{
    header("Location: posts.php?topic=".$topic);
    exit();
}