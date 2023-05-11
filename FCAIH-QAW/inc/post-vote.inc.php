<?php


include "dbh.inc.php";

$answer_id = $_POST['answer_id'];
$action = $_POST['action'];

if ($action == 'upvote') {
    $sql = "UPDATE questions SET upvotes = upvotes + 1 WHERE answer_id = ?";
} else {
    $sql = "UPDATE questions SET downvotes = downvotes + 1 WHERE answer_id = ?";
}

$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, 'i', $postId);
mysqli_stmt_execute($stmt);

// Get the updated vote count
$sql = "SELECT upvotes, downvotes FROM questions WHERE q_id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, 'i', $postId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

echo $row['upvotes'] - $row['downvotes'];

?>