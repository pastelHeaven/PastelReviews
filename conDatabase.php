<?php
// thsi is my connect database with uses pdo ive mostly use this of reviews page, i have another conn file which i 
// used for user regeiater called conn.php that uses mysqli
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
