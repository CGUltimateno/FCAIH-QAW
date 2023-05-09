<?php

require_once ('inc/dbh.inc.php');

// Check database connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the report type, description, and any other relevant information
    $report_type = $_POST["report_type"];
    $description = $_POST["description"];
    $reported_user_id = $_POST["id"];

    // Insert report into database
    $sql = "INSERT INTO reports (user_id, report_type, description) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($db);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die('SQL error');
    } else {
        mysqli_stmt_bind_param($stmt, "sss", $reported_user_id, $report_type, $description);
        mysqli_stmt_execute($stmt);
    }

    // Redirect to success page
    header("Location: users-view.php");
    exit();
}