<?php
//this is the post.php file which handles the post creation and moderation check for the forms, when the user clicks on the create post button in the forms.php file, 
// it will redirect to this page and the user can create a post and it will be inserted into the database and the user will be redirected back to the forms.php page after the post is created

session_start();
require 'conn.php';

$message = "";
$message_type = ""; 

// Show error message if user isn't logged in
if (!isset($_SESSION["user_id"])) {
    $message = "You must be logged in to create a forum post.";
    $message_type = "error";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION["user_id"];
    $title = $_POST["title"];
    $category = $_POST["category"]; 
    $content = $_POST["content"];

    // this is basic moderation check to check if the post contains any offensive words, this is just a basic check and can be improved by using maybe ai moderation
    // or mods to check the post before it is posted, this is just a basic check to see if the post contains any offensive wordsbut for right now this is just a basic check
    $offensivewords = ['badword1', 'badword2', 'badword4', 'badword3']; 
    $found_offensive = false;

    foreach ($offensivewords as $word) {
        if (stripos($title, $word) !== false || stripos($content, $word) !== false) {
            $found_offensive = true;
            break;
        }
    }
// identify if the post contains any offensive words and if it does then it will not be posted and the user will be notified that the post contains offensive words
    if ($found_offensive) {
        $message = "Your post contains inappropriate language. Please revise.";
    $message_type = "error";
    
    }else{

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO forum_post (user_id, title, category, content) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $category, $content);
    $stmt->execute();

    $message = "Your post has been created successfully!";
    $message_type = "success";}
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Create a Post</title>
  <style>
    body {
        background-color: #44008b;
        color: white;
        font-family: 'Segoe UI', sans-serif;
    }
    .alert {
    padding: 12px;
    text-align: center;
    margin: 20px auto;
    width: 340px;
    border-radius: 8px;
    font-weight: bold;
}

.alert.success {
    background-color: #c8f7c5;
    color: #2c662d;
    border: 1px solid #2c662d;
}

.alert.error {
    background-color: #ffcdd2;
    color: #c62828;
    border: 1px solid #c62828;
}

    .post-form-container {
        background: #9f45b0;
        padding: 25px;
        max-width: 700px;
        margin: 40px auto;
        border-radius: 12px;
    }

    .post-form-container h2 {
        color: #fff;
        margin-bottom: 20px;
    }

    .post-form-container input[type="text"],
    .post-form-container textarea,
    .post-form-container select {
        width: 94%;
        padding: 10px 14px;
        background-color: #2e004f;
        color: #ffccff;
        border: 1px solid #ff66cc;
        border-radius: 8px;
        font-size: 1rem;
        margin-bottom: 15px;
    }

    .post-form-container input::placeholder,
    .post-form-container textarea::placeholder {
        color: #cccccc;
    }

    .form-buttons {
        display: flex;
        justify-content: flex-end;
        padding: 9px;
        gap: 10px;
    }

    .form-buttons button {
        background-color: #ff66cc;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }

  </style>
</head>
<body>
<?php if (!empty($message)): ?>
    <div class="alert <?= $message_type ?>">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>


<div class="post-form-container">
    <h2>Create a Post</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Post Title" maxlength="300" <?= !isset($_SESSION["user_id"]) ? 'disabled' : '' ?>required>

        <label for="category">Category:</label>
        <select name="category" required>
            <option value="Retro">Retro</option>
            <option value="Advenature">Advenature</option>
            <option value="Shooter">Shooter</option>
            <option value="Open World">Open World</option>
            <option value="Horror">Horror</option>
            <option value="Platform">Platform</option>
        </select>

        <textarea name="content" placeholder="Post content..." rows="8" <?= !isset($_SESSION["user_id"]) ? 'disabled' : '' ?> required></textarea>

        <div class="form-buttons">
            <button type="submit" <?= !isset($_SESSION["user_id"]) ? 'disabled' : '' ?>>Post</button>
            <button type="button" onclick="window.location.href='forms.php'">Back</button>
        </div>
    </form>
</div>

</body>
</html>
