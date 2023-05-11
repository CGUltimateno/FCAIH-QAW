<?php

require_once('inc/dbh.inc.php');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $report_type = $_POST['report_type'];
    $description = $_POST['description'];
    $reported_user_id = $_POST['id'];
    $created_at = date('Y-m-d H:i:s');
    // Insert the report data into the database
    $sql = "INSERT INTO reports (user_id, report_type, description, date_reported) 
            VALUES ('$reported_user_id', '$report_type', '$description', '$created_at')";
    if (mysqli_query($db, $sql)) {
        // Send a confirmation message to the user
        echo "Report sent successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
}

mysqli_close($db);
