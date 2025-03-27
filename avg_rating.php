<?php
//this calculates the average rating of a game based on the reviews in the database
//it takes the game_id as a parameter and returns the average rating in JSON format


require_once 'conn.php'; //this is the database connection file to connevt to my database using mysqli

//this checks if the game_id is provided, if not it returns an error message in JSON format
if (isset($_GET['game_id'])) {
    $game_id = $_GET['game_id'];

    //thsi sql query selects the average rating from the review table using the key word AVG(rating) AS average_rating 
    // where the game id matches the provided game_id
    $query = "SELECT AVG(rating) AS average_rating FROM Review WHERE game_id = ?";
    //it uses a prepared statement to prevent SQL injection attacks
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();

    //this checks if the result is not empty, if it is not empty it fetches the average rating from the result set
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
