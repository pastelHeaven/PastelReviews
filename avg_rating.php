<?php
require_once 'conn.php'; // Database connection file

if (isset($_GET['game_id'])) {
    $game_id = $_GET['game_id'];

    $query = "SELECT AVG(rating) AS average_rating FROM Review WHERE game_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $average_rating = $row['average_rating'] ? round($row['average_rating'], 1) : "No ratings yet";
        echo json_encode(['average_rating' => $average_rating]);
    } else {
        echo json_encode(['error' => 'Failed to calculate average rating']);
    }
} else {
    echo json_encode(['error' => 'Game ID not provided']);
}
?>
