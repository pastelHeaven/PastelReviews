<?php
require_once "conDatabase.php"; //thsi connecct ot the database

// this get the game id 
$game_id = isset($_GET['game_id']) ? $_GET['game_id'] : null;

//this query slecets all from the game table where the game id is equal to the one passed in the url
$query = "SELECT * FROM Game WHERE game_id = game_id";
$stmt = $pdo->prepare($query);
$stmt->execute(["game_id" => $game_id]);
$game = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($game);
?>
