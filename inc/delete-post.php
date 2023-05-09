<?php
session_start();

if (isset($_GET['topic']) && isset($_GET['post']) && isset($_GET['by']) && isset($_SESSION['id']) && $_GET['by'] == $_SESSION['id'] && isset($_GET['topic'])) {
    require 'dbh.inc.php';

    $post = $_GET['post'];
    $topic = $_GET['topic'];

    $sql = "DELETE FROM answers WHERE id = ?";
    $stmt = mysqli_stmt_init($db);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../posts.php?topic=".$topic."&error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $post);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($db);
        header("Location: ../posts.php?topic=".$topic);
        exit();
    }

} else {
    header("Location: ../posts.php?topic=".$topic);
    exit();
}
