<?php
session_start();

require_once "conDatabase.php";

if (!isset($_POST['review_id']) || !isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

$review_id = $_POST['review_id'];
$user_id = $_SESSION['user_id'];

try {
    // Check if the user already liked this review
    $query = "SELECT * FROM Likes WHERE user_id = ? AND review_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $review_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User already liked, so remove the like
        $query = "DELETE FROM Likes WHERE user_id = ? AND review_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $user_id, $review_id);
        $stmt->execute();

        // Decrement the like count in Reviews table
        $query = "UPDATE Reviews SET likes = likes - 1 WHERE review_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $review_id);
        $stmt->execute();

        echo json_encode(["status" => "unliked"]);
    } else {
        // Add a new like
        $query = "INSERT INTO Likes (user_id, review_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $user_id, $review_id);
        $stmt->execute();

        // Increment the like count in Reviews table
        $query = "UPDATE Reviews SET likes = likes + 1 WHERE review_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $review_id);
        $stmt->execute();

        echo json_encode(["status" => "liked"]);
    }
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
