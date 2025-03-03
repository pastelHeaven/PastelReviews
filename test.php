<?php

session_start();

header("Content-Type: application/json"); // Ensure JSON response

require_once "conDatabase.php"; // Ensure your connection file is included

$response = ["success" => false, "message" => ""];

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $response["message"] = "Please log in to submit a review.";
    echo json_encode($response);
    exit;
}

$user_id = $_SESSION['user_id'];
$game_id = $_POST['game_id'] ?? null;
$rating = $_POST['rating'] ?? null;
$platform = $_POST['platform'] ?? null;
$review = $_POST['review_text'] ?? null;
$game_id = $_POST['game_id'] ?? null;

if (!$game_id) {
    echo json_encode(["success" => false, "message" => "Game ID missing."]);
    exit;
}

if (!$game_id || !$rating || !$platform || !$review) {
    echo json_encode(["success" => false, "message" => "Missing required fields."]);
    exit;
}


try {
    // Ensure the database connection uses the correct variable
    if (!isset($pdo)) {
        throw new Exception("Database connection not found.");
    }

    // Check if the user has already reviewed the game
    $query = "SELECT * FROM Review WHERE user_id = :user_id AND game_id = :game_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(["user_id" => $user_id, "game_id" => $game_id]);

    if ($stmt->rowCount() > 0) {
        $response["message"] = "You have already reviewed this game.";
        echo json_encode($response);
        exit;
    }

    // Insert new review
    $query = "INSERT INTO Review (user_id, game_id, rating, comment, platform) VALUES (:user_id, :game_id, :rating, :comment, :platform)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        "user_id" => $user_id,
        "game_id" => $game_id,
        "rating" => $rating,
        "comment" => $review,
        "platform" => $platform
    ]);

    $response["success"] = true;
    $response["message"] = "Review submitted successfully!";
} catch (Exception $e) {
    $response["message"] = "Database error: " . $e->getMessage();
}

echo json_encode($response);
?>
