<?php
// vote.php

include 'inc/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answerId = $_POST['answer_id'];
    $action = $_POST['action'];

        // Check if the user has already voted for this answer
        $hasVotedCookie = isset($_COOKIE['has_voted_'.$answerId]);
        if ($hasVotedCookie) {
            echo 'You have already voted for this answer.';
            exit();
        }
    

        if ($action == 'upvote') {
            $sql = "UPDATE answers SET upvotes = upvotes + 1 WHERE answer_id = ?";
        } elseif ($action == 'downvote') {
            $sql = "UPDATE answers SET downvotes = downvotes + 1 WHERE answer_id = ?";
        } elseif ($action == 'remove') {
            $sql = "UPDATE answers SET ";
            if ($oldAction == 'upvote') {
                $sql .= "upvotes = upvotes - 1 ";
            } elseif ($oldAction == 'downvote') {
                $sql .= "downvotes = downvotes - 1 ";
            }
            $sql .= "WHERE answer_id = ?";
        }
        

    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $answerId);
    mysqli_stmt_execute($stmt);

        // Set a cookie to indicate that the user has voted for this answer
        setcookie('has_voted_'.$answerId, true, time() + (86400 * 30), '/'); // Expires in 30 days

    // Get the updated vote count
    $sql = "SELECT upvotes - downvotes as total_votes FROM answers WHERE answer_id = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $answerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $totalVotes = $row['total_votes'];
    echo $totalVotes;

}
?>