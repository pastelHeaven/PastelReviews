<?php
require_once "conDatabase.php";

$apiResponse = file_get_contents("https://api.igdb.com/v4/games");
$games = json_decode($apiResponse, true);

foreach ($games as $game) {
    $api_id = $game['id'];
    $title = $game['name'];
    $description = $game['summary'] ?? 'No description available.';
    $cover = isset($game['cover']['image_id']) ? "https://images.igdb.com/igdb/image/upload/t_cover_big/{$game['cover']['image_id']}.jpg" : "img/placeholder.jpg";
    $release_date = isset($game['first_release_date']) ? date("Y-m-d", $game['first_release_date']) : null;

    // Check if the game exists
    $query = "SELECT id FROM Game WHERE api_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $api_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert new game
        $insertQuery = "INSERT INTO Game (title, api_id, description, cover, release_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sisss", $title, $api_id, $description, $cover, $release_date);
        $stmt->execute();
    }
}

echo "Database updated successfully!";

?>