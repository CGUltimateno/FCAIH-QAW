<?php
session_start();

if (isset($_GET['answer_id'])) {
    require 'dbh.inc.php';
    $a_id = $_GET['answer_id'];
    $q_id = $_GET['q_id'];
    $sql = "DELETE FROM answers WHERE answer_id = $a_id";
    mysqli_query($db, $sql);
    header("Location: ../posts.php?topic=$q_id");
}
?>