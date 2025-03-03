<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: Login.php");

}
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
            <a href="index.html" class="logo">PastelReviews</a>
            <nav>
                <ul class="nav-list">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="profile-pic">
                <img src="default-avatar.png" alt="User Profile Picture">
                <input type="file" id="upload-profile-pic" name="profile-pic" style="display:none;">
                <label for="upload-profile-pic">Change Profile Picture</label>
            </div>
            <div class="user-info">
                <h2>User Name</h2>
                <p><strong>Bio:</strong> A brief bio about the user.</p>
                <a href="#">Edit Bio</a>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#reviews">My Reviews</a></li>
                <li><a href="#likes">My Likes</a></li>
            </ul>
        </aside>

        <main class="content">
            <section id="reviews" class="section">
                <h2>My Reviews</h2>
                <div class="reviews-list">
                    <!-- Example of a review -->
                    <div class="review-item">
                        <h3>Game Title</h3>
                        <p>Your review content goes here...</p>
                        <a href="#">Edit Review</a>
                    </div>
                </div>
            </section>

            <section id="likes" class="section">
                <h2>My Likes</h2>
                <div class="likes-list">
                    <!-- Example of a liked item -->
                    <div class="like-item">
                        <h3>Game Title</h3>
                        <p>Brief description of the liked content...</p>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
