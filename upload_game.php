<?php
//ive implemanted the code which iused in my main upload game php as i ahve decide of using the upload diectirt code
session_start();
require_once "conn.php"; 
$message = "";
$message_type = ""; 

if (!isset($_SESSION["user_id"])) {
    $message = "You must be logged in to create a forum post.";
    $message_type = "error";
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
        $message =("Error: Missing required fields.");
        $message_type = "error";
        
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
            $message = "Game uploaded successfully!";
            $message_type = "success";

        } else {
            $message = "Database error: " . mysqli_error($conn);
            $message_type = "error";
        }
    } else {
        $message =  "Error: Could not move uploaded files.";
        $message_type = "error";
    }
} 

?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="Upload.css" rel="stylesheet" type="text/css" />
    <title>PastelReviews</title>
  </head>
  <body>
    <main>
    <?php if (!empty($message)): ?>
    <div class="alert <?= $message_type ?>">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>
      <div class="upload-game-container">
        <h1>Upload a New Game</h1>

        <form
          id="upload-game-form"
          action="upload_game.php"
          method="POST"
          enctype="multipart/form-data"
        >
          <div class="form-group">
            <label for="title">Game Title:</label>
            <input type="text" id="title" name="title" required />
          </div>

          <div class="form-group">
            <label for="description">Description:</label>
            <textarea
              id="description"
              name="description"
              rows="4"
              required
            ></textarea>
          </div>

          <div class="form-group">
            <label for="genre">Genre:</label>
            <select id="genre" name="genre" required>
              <option value="Action">Action</option>
              <option value="Adventure">Adventure</option>
              <option value="RPG">RPG</option>
              <option value="Shooter">Shooter</option>
              <option value="Sports">Sports</option>
              <option value="Strategy">Strategy</option>
              <option value="Simulation">Simulation</option>
            </select>
          </div>

          <div class="form-group">
            <label for="game_image">Game Image:</label>
            <input
              type="file"
              id="game_image"
              name="game_image"
              accept="image/*"
              required
            />
          </div>

          <div class="form-group">
            <label for="submission_file">Game File:</label>
            <input
              type="file"
              id="submission_file"
              name="submission_file"
              accept=".zip,.rar,.7z,.exe"
              required
            />
          </div>

          <div class="form-group">
            <input type="checkbox" id="copyright" name="copyright" required>
            <label for="copyright">
              I confirm that I own the rights to all materials used in this game and agree to the
              <a href="copyright-declaration.html" target="_blank">Copyright Declaration</a>.
            </label>
          </div>
          

          <button class="submit-btn" type="submit" name="submit">
            Upload Game
          </button>
          <button class ="submit-btn" type="button" onclick="window.location.href='gamesupload.php'">Back</button>
        </form>
      </div>
    </main>
  </body>
</html>
