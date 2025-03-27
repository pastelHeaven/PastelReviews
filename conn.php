<?php
// thsis is my other connect database file which uses mysqli
$hostName = "localhost";
$dbUser = "oo303_game1";
$dbPassword = "gjGg9X43k1G(";
$dbName = "oo303_GameReview";

$conn = new mysqli($hostName, $dbUser, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>