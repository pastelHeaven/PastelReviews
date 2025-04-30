<?php
require_once "conn.php";
// this file is used to display the games uploaded by users, the games are fetched from the database and displayed in a grid format
$sql = "SELECT g.game_title, g.description, g.genre, g.cover_image, g.file_path, u.username 
        FROM Game_Upload g 
        JOIN users u ON g.user_id = u.id 
        ORDER BY g.upload_date DESC";
        
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta http-equiv="X-UA-Compatible" content="ie=edge" >
    <link href="GameReview.css" rel="stylesheet" type="text/css" >
    <title>PastelReviews</title>
</head>

<body>
    <!-- The Heading, logo and navigation bar -->
    <header class="header">
        <div class="container">
            <a href="index.html" class="logo" ><img src="img/Pastel.png" alt="PastelReviews"></a>
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
                        <input type="text" placeholder="Search.." name="search" >
                        <button type="submit"><img src="img/download.png" alt="Search"></button>
                    </form>
                </div>
                <div class="signup-button section">
            <a href="Login.php" class="btn">Login</a>
            <a href="Register.php" class="btn">Sign Up</a>
            <a href="dashboard.php" class="btn">Dashboard</a>
          </div>
            </div>
        </div>
    </header>
    
    <main>

        <div class="upload-header">
            <h1>Top indie games</h1>
            <a href="upload_game.php" class="create-btn">Upload your Game</a>
        </div>
        <div class="upload-grid">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="upload-card">
                    <img src="<?= htmlspecialchars($row['cover_image']) ?>" alt="upload Cover" class="upload-cover">
                    <h3 class="upload-title"><?= htmlspecialchars($row['game_title']) ?></h3>
                    <p class="upload-desc"><?= htmlspecialchars($row['description']) ?></p>
                    <p class="upload-meta">by <span class="uploader"><?= htmlspecialchars($row['username']) ?></span></p>
                    <p class="upload-genre"><?= htmlspecialchars($row['genre']) ?></p>
                    <p class="upload-link">Click to download:
                        <a href="<?= htmlspecialchars($row['file_path']) ?>" download>Here</a>
                    </p>
                </div>
            <?php endwhile; ?>
            </div>
            <!-- </div>
        <div class="upload-grid">
            <div class="upload-card">
              <img src="img/2odx6gpsgR6qQ16YZ7YkEt2B.png" alt="upload Cover" class="upload-cover">
              <h3 class="upload-title">The Station (V1.21)</h3>
              <p class="upload-desc">Just a typical subway ride...</p>
              <pi class="upload-meta">by <span class="uploader">RiverSoftware</span></p>
              <p class="upload-genre">Adventure</p>
              <p class="upload-link">Click to download:<a href="">Here</a></p>
            </div>
          
            <div class="upload-card">
                <img src="img/2odx6gpsgR6qQ16YZ7YkEt2B.png" alt="upload Cover" class="upload-cover">
                <h3 class="upload-title">The Station (V1.21)</h3>
                <p class="upload-desc">Just a typical subway ride...</p>
                <p class="upload-meta">by <span class="uploader">RiverSoftware</span></p>
                <p class="upload-link">Click to download:<a href="">Here</a></p>
              </div>
          
              <div class="upload-card">
                <img src="img/2odx6gpsgR6qQ16YZ7YkEt2B.png" alt="upload Cover" class="upload-cover">
                <h3 class="upload-title">The Station (V1.21)</h3>
                <p class="upload-desc">Just a typical subway ride...</p>
                <p class="upload-meta">by <span class="uploader">RiverSoftware</span></p>
                <p class="upload-genre">Adventure</p>
              </div>
              <div class="upload-card">
                <img src="img/2odx6gpsgR6qQ16YZ7YkEt2B.png" alt="upload Cover" class="upload-cover">
                <h3 class="upload-title">The Station (V1.21)</h3>
                <p class="upload-desc">Just a typical subway ride...</p>
                <p class="upload-meta">by <span class="uploader">RiverSoftware</span></p>
                <p class="upload-genre">Adventure</p>
              </div>
              <div class="upload-card">
                <img src="img/2odx6gpsgR6qQ16YZ7YkEt2B.png" alt="upload Cover" class="upload-cover">
                <h3 class="upload-title">The Station (V1.21)</h3>
                <p class="upload-desc">Just a typical subway ride...</p>
                <p class="upload-meta">by <span class="uploader">RiverSoftware</span></p>
                <p class="upload-genre">Adventure</p>
              </div>
              <div class="upload-card">
                <img src="img/2odx6gpsgR6qQ16YZ7YkEt2B.png" alt="upload Cover" class="upload-cover">
                <h3 class="upload-title">The Station (V1.21)</h3>
                <p class="upload-desc">Just a typical subway ride...</p>
                <p class="upload-meta">by <span class="uploader">RiverSoftware</span></p>
                <p class="upload-genre">Adventure</p>
              </div>
              <div class="upload-card">
                <img src="img/2odx6gpsgR6qQ16YZ7YkEt2B.png" alt="upload Cover" class="upload-cover">
                <h3 class="upload-title">The Station (V1.21)</h3>
                <p class="upload-desc">Just a typical subway ride...</p>
                <p class="upload-meta">by <span class="uploader">RiverSoftware</span></p>
                <p class="upload-genre">Adventure</p>
              </div>
              <div class="upload-card">
                <img src="img/2odx6gpsgR6qQ16YZ7YkEt2B.png" alt="upload Cover" class="upload-cover">
                <h3 class="upload-title">The Station (V1.21)</h3>
                <p class="upload-desc">Just a typical subway ride...</p>
                <p class="upload-meta">by <span class="uploader">RiverSoftware</span></p>
                <p class="upload-genre">Adventure</p>
              </div> -->


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
</body>

</html>