<?php
session_start();

require 'conn.php';
$result = $conn->query("SELECT post_id, title, category, created_at FROM forum_post ORDER BY created_at DESC");

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
    .forum-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .thread-card {
        background-color: #0007;
        border-radius: 10px;
        margin-bottom: 20px;
        padding: 30px;
        transition: transform 0.2s;
    }

    .thread-card:hover {
        transform: scale(1.01);
        box-shadow: 0 0 12px #a29bfe;
    }

    .thread-title {
        font-size: 20px;
        color: #fff;
        margin-bottom: 5px;
    }

    .thread-meta {
        font-size: 14px;
        color: #bbb;
    }

    .badge {
        background-color: #6c5ce7;
        color: white;
        padding: 2px 8px;
        border-radius: 5px;
        font-size: 12px;
        margin-left: 10px;
    }

    .forum-header {
        max-width: 883px;
        margin: 0px auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }

    .create-btn {
        background-color: #ec4dac;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
        transition: background-color 0.3s;
    }

    .create-btn:hover {
        background-color: #ffe4f2;
        color: #000;
    }

</style>

<body>
    <!-- The Heading, logo and navigation bar -->
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
    <main>

        <div class="forum-header">
            <h1>Forum Discussions</h1>
           <a href="post.php"><button class="create-btn">Create a post</button></a> 
        </div>

        
        <div class="forum-container">
            <!-- This display the forum post that the user made from the database using fetch_assoc -->
    <?php while ($row = $result->fetch_assoc()) : ?>
        <div class="thread-card">
            <a href="forms-details.php?post_id=<?= $row['post_id'] ?>" style="text-decoration: none;">
                <div class="thread-title"><?= htmlspecialchars($row['title']) ?></div>
            </a>
            <div class="thread-meta">
                Posted • <?= date("F j, Y, g:i a", strtotime($row['created_at'])) ?>
                <span class="badge"><?= htmlspecialchars($row['category']) ?></span>
            </div>
        </div>
    <?php endwhile; ?>
</div>


        <!-- <div class="forum-container">
            <div class="thread-card">
                <div class="thread-title">What game made you cry?</div>
                <div class="thread-meta">Posted by <strong>user123</strong> • 2 hours ago <span
                        class="badge">Gaming</span></div>
            </div>

            <div class="thread-card">
                <div class="thread-title">Best underrated PS2 games?</div>
                <div class="thread-meta">Posted by <strong>retrolover</strong> • 1 day ago <span
                        class="badge">Retro</span></div>
            </div>

            <div class="thread-card">
                <div class="thread-title">Would you buy a Steam Deck 2?</div>
                <div class="thread-meta">Posted by <strong>gadgetgeek</strong> • 3 minutes ago <span
                        class="badge">Hardware</span></div>
            </div>
        </div> -->
</body>
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

</html>