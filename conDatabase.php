<?php

$hostName = "localhost";
$dbUser = "oo303_game1";
$dbPassword = "gjGg9X43k1G(";
$dbName = "oo303_GameReview";

try {
    $pdo = new PDO("mysql:host=$hostName;dbname=$dbName", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}



?>
