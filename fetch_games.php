<?php

require_once "conDatabase.php"; 
if (!isset($pdo)) {
    die("Database connection error.");
}
//this get the game dfrom the database and return it as a JSON response for it to be use in the fetch_games.js file
$query = "SELECT game_id, title, description, genre, platform, release_date, cover, api_id FROM Game";
$stmt = $pdo->prepare($query);
$stmt->execute();
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($games);

?>
