<?php
// this is my dashboard page where i will be able to see my reviews and likes this will get the data from the database and display 
// it in a nice way for the user to see their reviews and likes, it uses the user id 

session_start();
require_once "conDatabase.php"; 
//
if (!isset($_SESSION["user_id"])) {
    header("Location: Login.php");
    exit();
}

$user_id = $_SESSION["user_id"];


// this fetches the user's reviews
$query = "SELECT r.comment, r.rating, r.platform, r.created_at, g.title AS game_title
          FROM Review r
          JOIN Game g ON r.game_id = g.game_id
          WHERE r.user_id = ?
          ORDER BY r.created_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<header class="header">
        <div class="container">
            <a href="index.html" class="logo" alt="PastelReviews"><img src="img/Pastel.png"></a>
            <ul class="nav-list section1">
                <li class="nav-items"><a href="index.html">Home</a></li>
                <li class="nav-items"><a href="gameGrid.html">Games</a></li>
                <li class="nav-items"><a href="news.html">Gaming News</a></li>
                <li class="nav-items"><a href="gamesupload.php">Gaming Upload</a></li>
                <li class="nav-items"><a href="forms.php">Gaming Forms</a></li>
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
                    <a href="logout.php"><button class="signup">Logout</button></a>
                </div>
            </div>
        </div>
    </header>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="profile-pic">
                <img src="img/—Pngtree—gray avatar placeholder_6398267.png" alt="User Profile Picture">
        
                <p style="color:white; margin-top: 10px;">Welcome Back</p>
            </div>
           
           
        </aside>
<!-- the users reveiw appeares here -->
        <main class="content">
            <section id="reviews" class="section">
                <h2>My Reviews</h2>
                <div class="reviews-list">
    <?php if (count($reviews) > 0): ?>
        <?php foreach ($reviews as $review): ?>
            <div class="review-item">
                <h3><?= htmlspecialchars($review['game_title']) ?></h3>
                <p><strong>Platform:</strong> <?= htmlspecialchars($review['platform']) ?></p>
                <p><strong>Rating:</strong> <?= htmlspecialchars($review['rating']) ?> ★</p>
                <p><?= htmlspecialchars($review['comment']) ?></p>
                <small><em>Posted on <?= date('F j, Y', strtotime($review['created_at'])) ?></em></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>You haven't written any reviews yet.</p>
    <?php endif; ?>
</div>


            <!-- <section id="likes" class="section">
                <h2>My Likes</h2>
                <div class="likes-list">
                    Example of a liked item -->
                    <!-- <div class="like-item">
                        <h3>Game Title</h3>
                        <p>Brief description of the liked content...</p>
                    </div>
                </div>
            </section> --> 
        </main>
    </div>
</body>
</html>
