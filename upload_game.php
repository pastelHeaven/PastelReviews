<?php
//ive implemanted the code which iused in my main upload game php as i ahve decide of using the upload diectirt code
session_start();
require_once "conn.php"; 

if (!isset($_SESSION["user_id"])) {
    die("Error: You must be logged in to upload a game. <a href='Login.php'>Login Here</a>");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION["user_id"];

    // Check if all fields exist before using them
    if (
        !isset($_POST["title"]) || 
        !isset($_POST["description"]) || 
        !isset($_POST["genre"]) || 
        !isset($_FILES["game_image"]) || 
        !isset($_FILES["submission_file"])
    ) {
        die("Error: Missing required fields.");
    }

    $gameTitle = $_POST["title"];
    $description = $_POST["description"];
    $genre = $_POST["genre"];

    $targetDir = "uploads/";

 
    $imageFile = $_FILES["game_image"];
    $imageFileName = basename($imageFile["name"]);
    $imageFilePath = $targetDir . "covers/" . $imageFileName;

    // Handle game submission file upload
    $gameFile = $_FILES["submission_file"];
    $gameFileName = basename($gameFile["name"]);
    $gameFilePath = $targetDir . "games/" . $gameFileName;
    $gameFileSize = $gameFile["size"];

    // Move uploaded files
    if (move_uploaded_file($imageFile["tmp_name"], $imageFilePath) && move_uploaded_file($gameFile["tmp_name"], $gameFilePath)) {
        //  Insert into database
        $sql = "INSERT INTO Game_Upload (user_id, game_title, description, genre, cover_image, file_path, file_size, upload_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "issssss", $userId, $gameTitle, $description, $genre, $imageFilePath, $gameFilePath, $gameFileSize);

        if (mysqli_stmt_execute($stmt)) {
            echo "Game uploaded successfully!";
        } else {
            echo "Database error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: Could not move uploaded files.";
    }
} else {
    die("Invalid request.");
}
?>
