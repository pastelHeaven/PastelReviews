<?php
session_start();
require_once "conDatabase.php";

if (isset($_POST['submit'])) {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        die("You must be logged in to upload a game.");
    }

    $title = $_POST['title'];
    $description = $_POST['description'];
    $genre = $_POST['genre'];
    $user_id = $_SESSION['user_id'];

    // File upload directories
    $upload_dir = "uploads/";
    $browser_dir = "uploads/browser/";
    $compressed_dir = "uploads/compressed/";
    $executable_dir = "uploads/executable/";
    $cover_dir = "uploads/covers/";

    // Create directories if they don't exist
    if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
    if (!file_exists($browser_dir)) mkdir($browser_dir, 0777, true);
    if (!file_exists($compressed_dir)) mkdir($compressed_dir, 0777, true);
    if (!file_exists($executable_dir)) mkdir($executable_dir, 0777, true);
    if (!file_exists($cover_dir)) mkdir($cover_dir, 0777, true);

    // Handle Game File Upload
    $game_file_name = basename($_FILES["submission_file"]["name"]);
    $game_file_tmp = $_FILES["submission_file"]["tmp_name"];
    $game_file_type = strtolower(pathinfo($game_file_name, PATHINFO_EXTENSION));

    // Allowed file types
    $browser_formats = ["zip"];  // HTML5 Browser-Based Games
    $compressed_formats = ["zip", "rar", "7z"];  // Compressed Archives
    $executable_formats = ["exe", "dmg", "appimage"];  // Executables

    if (in_array($game_file_type, $browser_formats)) {
        $target_file = $browser_dir . $game_file_name;
    } elseif (in_array($game_file_type, $compressed_formats)) {
        $target_file = $compressed_dir . $game_file_name;
    } elseif (in_array($game_file_type, $executable_formats)) {
        $target_file = $executable_dir . $game_file_name;
    } else {
        die("Error: Invalid file type. Please upload a valid game file (.zip, .rar, .7z, .exe, .dmg, .appimage).");
    }

    // Move the game file to the correct directory
    if (!move_uploaded_file($game_file_tmp, $target_file)) {
        die("Error: Unable to upload the game file.");
    }

    // Handle Game Cover Image Upload
    $cover_file_name = basename($_FILES["game_image"]["name"]);
    $cover_file_tmp = $_FILES["game_image"]["tmp_name"];
    $cover_file_type = strtolower(pathinfo($cover_file_name, PATHINFO_EXTENSION));

    $allowed_image_formats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($cover_file_type, $allowed_image_formats)) {
        die("Error: Invalid cover image format. Please upload a JPG, PNG, or GIF file.");
    }

    $cover_target_file = $cover_dir . $cover_file_name;
    if (!move_uploaded_file($cover_file_tmp, $cover_target_file)) {
        die("Error: Unable to upload the game cover image.");
    }

    // Insert Game Data into Database
    $query = "INSERT INTO Game_Upload (user_id, game_title, description, genre, file_path, cover_path) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssss", $user_id, $title, $description, $genre, $target_file, $cover_target_file);

    if ($stmt->execute()) {
        echo "Game uploaded successfully!";
    } else {
        echo "Error uploading game: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
