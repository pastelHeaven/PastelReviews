<?php
// simular to fech game php this get reviews frpm the database
require_once "conDatabase.php";

$game_id = isset($_GET["game_id"]) ? intval($_GET["game_id"]) : null;

if (!$game_id) {
    echo json_encode(["error" => "Game ID is required"]);
    exit;
}

//this query selects the reveiw information form the reveiw atble and join it to uers id  where the game id is what the user clicked
$query = "SELECT r.comment, r.rating, r.platform, u.username, r.created_at 
          FROM Review r
          JOIN Users u ON r.user_id = u.id
          WHERE r.game_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$game_id]);

$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($reviews);
?>
