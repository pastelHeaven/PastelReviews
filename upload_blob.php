<?php

// this file is for testing the storage of blob files.
require_once "conn.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $user_id = isset($_POST["user_id"]) ? intval($_POST["user_id"]) : null; 
    $game_title = $_POST["game_title"];
    $file_name = $_FILES["file"]["name"];
    $file_type = $_FILES["file"]["type"];
    $file_size = $_FILES["file"]["size"];
    $file_data = file_get_contents($_FILES["file"]["tmp_name"]);
    
    if (!$user_id) {
        die("Error: User ID is required.");
    }

    $sql = "INSERT INTO temp_blob_storage (user_id, game_title, file_name, file_type, file_size, file_data, upload_date) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssis", $user_id, $game_title, $file_name, $file_type, $file_size, $file_data);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "File uploaded successfully!";
    } else {
        echo "Error uploading file: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
