<?php
session_start();
include_once 'dbh.inc.php';
if(isset($_POST['question'])) {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $comm_id = $_POST['comm_id'];

    if(empty($title) || empty($body)) {
        header("Location: ../question.php?comm_id=".$comm_id."&error=emptyfields");
        exit();
    } else {
        $sql = "INSERT INTO questions (title, body, comm_id, user_id) VALUES (?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($db);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../question.php?comm_id=".$comm_id."&error=sqlerror");
            exit();
        } else {
            $user_id = $_SESSION['id']; // get the ID of the currently logged-in user
            mysqli_stmt_bind_param($stmt, "ssss", $title, $body, $comm_id, $user_id); // add user_id to the query
            mysqli_stmt_execute($stmt);
            header("Location: ../comm.php?comm_id=".$comm_id."&operation=success");
            exit();
        }
    }
} else {
    header("Location: ../question.php?comm_id=".$comm_id);
    exit();
}