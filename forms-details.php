<?php
// this file is used to display the post page and the comment section of the post page, this is where the user can view the post and comment on the post
session_start();
require 'conn.php';
//thses are the variables that are used to display the message to the user when they try to post a comment, 
$message = "";
$message_type = "";

if (!isset($_GET['post_id'])) {
    die("Post ID is missing.");
}
$post_id = intval($_GET['post_id']);

// the fetch the post from the database using the post id that is passed in the url, this is used to display the post on the post page
$stmt = $conn->prepare("SELECT p.title, p.content, p.created_at, p.category, u.username 
                        FROM forum_post p 
                        JOIN users u ON p.user_id = u.id 
                        WHERE p.post_id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Post not found.");
}

$post = $result->fetch_assoc();


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["comment_text"])) {

    if (!isset($_SESSION["user_id"])) {
        $message = "You must be logged in to leave a comment.";
        $message_type = "error";
    } else {
        $user_id = $_SESSION["user_id"];
        $comment_text = trim($_POST["comment_text"]);

        // simularly to the post moderation check, this checks if the comment contains any offensive words and if it 
        // does then it will not be posted and the user will be notified that the comment contains offensive words
        $offensivewords = ['badword1', 'badword2', 'badword4', 'badword3'];
        $found_offensive = false;

        foreach ($offensivewords as $word) {
            if (stripos($comment_text, $word) !== false) {
                $found_offensive = true;
                break;
            }
        }
        if ($found_offensive) {
            $message = "Your comment contains inappropriate language. Please revise.";
            $message_type = "error";
        } else {
            $stmt = $conn->prepare("INSERT INTO forum_comments (post_id, user_id, comment_text) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $post_id, $user_id, $comment_text);
            $stmt->execute();

            // this refresh page so that the comment is displayed on the page after it is posted
            header("Location: forms-details.php?post_id=" . $post_id);
            exit();
        }
    }
}

// this fetches the comments for the post from the database and displays them on the post page, this is determined by the post id 
// that is passed in the url, this is used to display the comments for the post
$comments_stmt = $conn->prepare("SELECT c.comment_text, c.created_at, u.username 
                                 FROM forum_comments c 
                                 JOIN users u ON c.user_id = u.id 
                                 WHERE c.post_id = ? 
                                 ORDER BY c.created_at ASC");
$comments_stmt->bind_param("i", $post_id);
$comments_stmt->execute();
$comments_result = $comments_stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="GameReview.css" rel="stylesheet" type="text/css" />
    <title>PastelReviews</title>
</head>

<style>
  
    .post-page {

        padding: 30px;
        max-width: 800px;
        margin: 0 auto;
    }

    .post-meta {
        color: #aaa;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .community {
        color: #ff99ff;
    }

    .post-title {
        color: #ffffff;
        font-size: 1.8rem;
        margin: 0 0 10px;
    }

    .post-body {
        color: #d1b3ff;
        font-size: 1rem;
        margin-bottom: 20px;
    }

    .post-actions button {
        background: #4a0072;
        color: #ffd6ff;
        border: 1px solid #ff66cc;
        padding: 8px 14px;
        margin-right: 8px;
        border-radius: 5px;
        cursor: pointer;
    }

    .comment-section {
        margin-top: 30px;
    }

    .comment {
        background-color: #290050;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 15px;
        box-shadow: inset 0 0 6px #5d2b97;
    }

    .comment-user {
        font-weight: bold;
        font-size: 0.95rem;
        color: #d6aaff;
    }

    .comment-text {
        margin: 8px 0;
        font-size: 0.95rem;
        color: #f3e0ff;
    }

    .comment-actions button {
        background: none;
        border: none;
        color: #bb80ff;
        cursor: pointer;
        font-size: 0.9rem;
        margin-right: 10px;
    }

    .comment-form {
        margin-top: 20px;
    }

    .comment-input {
        width: 100%;
        padding: 12px 20px;
        background-color: #9f45b080;
        color: white;
        border: 1px solid #444;
        border-radius: 999px;
        font-size: 1rem;
        transition: border 0.3s, box-shadow 0.3s;
    }
    .alert {
    padding: 12px;
    text-align: center;
    margin: 20px auto;
    width: 340px;
    border-radius: 8px;
    font-weight: bold;
}



.alert.error {
    background-color: #ffcdd2;
    color: #c62828;
    border: 1px solid #c62828;
}
    .comment-input::placeholder {
        color: #aaa;
    }

    .comment-input:focus {
        outline: none;
        border-color: #ff66cc;
        box-shadow: 0 0 0 2px #ff66cc44;
    }
</style>

<body>
    <header class="header">
        <div class="container">
            <a href="index.html" class="logo" alt="PastelReviews"><img src="img/Pastel.png"></a>
            <ul class="nav-list section1">
                <li class="nav-items"><a href="index.html">Home</a></li>
                <li class="nav-items"><a href="gameGrid.html">Games</a></li>
                <li class="nav-items"><a href="news.html">Gaming News</a></li>
                <li class="nav-items"><a href="gamesupload.php">Gaming Upload</a></li>
                <li class="nav-items"><a href="forms.php">Gaming Forums</a></li>
                <li class="nav-items"><a href="FAQ.html">FAQ</a></li>
            </ul>
            <div class="search-signup-container">
                <div class="search-bar section">
                    <form action="#">
                        <input type="text" placeholder="Search.." name="search" />
                        <button type="submit"><img src="img/download.png" alt="Search"></button>
                    </form>
                </div>
                <div class="signup-button section3">
                    <a href="Login.php"><button class="login">Login</button></a>
                    <a href="Register.php"><button class="signup">Sign Up</button></a>
                    <a href="dashboard.php"><button class="signup">Dashboard</button></a>
                </div>
            </div>
        </div>
    </header>
<!-- //the error message is displayed here when the user tries to post a comment and it fails,
  this is used to notify the user that the comment was not posted and why it was not posted -->
    <?php if (!empty($message)): ?>
    <div class="alert <?= $message_type ?>">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>


    <div class="post-page">
        <!-- this is the post page, this is where the post is displayed and the comment section is displayed -->
        <div class="post-header">
            <div class="post-meta">
                <span class="community">r/pastelgames</span> •
                <span class="timestamp"><?= date("F j, Y, g:i a", strtotime($post['created_at'])) ?></span> •
                <span>by <?= htmlspecialchars($post['username']) ?></span>
            </div>

            <h1 class="post-title"><?= htmlspecialchars($post['title']) ?></h1>
            <p class="post-body"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            <div class="post-actions">
                <button>⭐ 45</button>
                <button>💬 9</button>
                <button>🔗 Share</button>
            </div>
            <form method="POST" action="forms-details.php?post_id=<?= $post_id ?>" class="comment-form">
                <input type="text" name="comment_text" placeholder="Add a comment" class="comment-input" required>
                <input type="hidden" name="post_id" value="<?= $post_id ?>">
                <input type="submit" style="display:none;">
            </form>



            <!-- <div class="post-meta">
      <span class="community">r/pastelgames</span> • <span class="timestamp">1 hour ago</span>
    </div>
    <h1 class="post-title">What are your MUST play games?</h1>
    <p class="post-body">
      Games like Skyrim, Portal, Red Dead — those iconic ones. What are yours?
    </p>
  </div> -->

            <div class="comment-section">
                <h3>Comments</h3>
                <?php while ($comment = $comments_result->fetch_assoc()): ?>
                    <div class="comment">
                        <p class="comment-user"><?= htmlspecialchars($comment['username']) ?> <span>•
                                <?= date("g:i a", strtotime($comment['created_at'])) ?></span></p>
                        <p class="comment-text"><?= nl2br(htmlspecialchars($comment['comment_text'])) ?></p>
                        <div class="comment-actions">
                            <button>⬆️</button>
                            <button>💬 Reply</button>
                            <button>🔗 Share</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>


            <!-- <div class="post-actions">
    <button>⭐ 45</button>
    <button>💬 9</button>
    <button>🔗 Share</button>
  </div>

  <div class="comment-section">
    <h3>Comments</h3>
    <div class="comment">
      <p class="comment-user">AntonRX178 <span>• 2h ago</span></p>
      <p class="comment-text">Ratchet and Clank and Yakuza. No debate.</p>
      <div class="comment-actions">
        <button>⬆️</button>
        <button>💬 Reply</button>
        <button>🔗 Share</button>
      </div>
    </div> -->
            <!-- More comments... -->
        </div>
    </div>
    </main>
    <footer class="footer">
    <div class="footer-heading">
      <h1>OUR NEWSLETTER</h1>
    </div>
    <div class="footer-newsletter">
      <p>Subscribe to our gaming newsletter</p>
      <div class="newsletter-signup">
        <input type="email" placeholder="Enter your email...">
        <button class="subscribe">SUBSCRIBE</button>
      </div>
    </div>
    <div class="footer-navigation">
      <nav>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="gameGrid.html">Games</a></li>
          <li><a href="news.html">Gaming News</a></li>
          <li><a href="gamesupload.php">Gaming Upload</a></li>
          <li><a href="forms.php">Gaming Forums</a></li>
          <li><a href="FAQ.html">FAQ</a></li>
        </ul>
      </nav>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2024 Onome</p>
    </div>
  </footer>
    <html>
</body>