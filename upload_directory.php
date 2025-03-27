<?php
require_once "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Check if all form fields are set
    if (!isset($_POST["user_id"], $_POST["game_title"], $_FILES["file"])) {
        die("Error: Missing form fields.");
    }

    // Get form data
    $userId = intval($_POST["user_id"]); // Convert to integer
    $gameTitle = trim($_POST["game_title"]); // Remove whitespace
    $file = $_FILES["file"];

    // Directory where files will be stored
    $targetDir = "uploads/";

    // Ensure the directory exists
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // File details
    $fileName = basename($file["name"]);
    $filePath = $targetDir . $fileName;
    $fileType = $file["type"];
    $fileSize = $file["size"];

    // Check for file upload errors
    if ($file["error"] !== UPLOAD_ERR_OK) {
        die("Error: File upload failed with error code " . $file["error"]);
    }

    // Move uploaded file
    if (move_uploaded_file($file["tmp_name"], $filePath)) {
        // Insert into database
        $sql = "INSERT INTO temp_directory_storage (user_id, game_title, file_name, file_type, file_size, file_path) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        
        mysqli_stmt_bind_param($stmt, "isssis", $userId, $gameTitle, $fileName, $fileType, $fileSize, $filePath);
        if (mysqli_stmt_execute($stmt)) {
            echo "Game file uploaded and stored in directory successfully!";
        } else {
            echo "Database insert failed: " . mysqli_error($conn);
        }
    } else {
        echo "Error: Could not upload the file.";
    }
} else {
    echo "Invalid request.";
}
?>
