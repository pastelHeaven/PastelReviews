<?php
require_once "conDatabase.php";

$game_id = isset($_GET['game_id']) ? $_GET['game_id'] : null;


$query = "SELECT * FROM Game WHERE game_id = :game_id";
$stmt = $pdo->prepare($query);
$stmt->execute(["game_id" => $game_id]);
$game = $stmt->fetch(PDO::FETCH_ASSOC);


header('Content-Type: application/json');
echo json_encode($game);
?>
