<?php

$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "12345";
$dBName = "database";

$db = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$db)
{
    die("Connection failed: ". mysqli_connect_error());
}



