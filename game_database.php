<?php
// Database connection
$hostName = "localhost";
$dbUser = "oo303_game1";
$dbPassword = "gjGg9X43k1G(";
$dbName = "oo303_GameReview";

try {
    $pdo = new PDO("mysql:host=$hostName;dbname=$dbName", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$accessToken = 'arxqn51p65ej84xlt4seqd3ycgnwup';
$clientId = 'y0bo6jm5v1km9xwv984yffs62vnrkk';

$url = "https://api.igdb.com/v4/games";
$requestBody = "fields id, name, summary, genres, first_release_date, cover.image_id, platforms; limit 20;";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Client-ID: $clientId",
    "Authorization: Bearer $accessToken",
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);

$data = json_decode($response, true);

if (!$data || !is_array($data)) {
    die("Failed to decode API response.");
}

foreach ($data as $game) {
    $apiId = $game['id'];
    $title = $game['name'];
    $description = $game['summary'] ?? 'No description available.';
    $releaseDate = isset($game['first_release_date']) 
        ? date('Y-m-d', $game['first_release_date']) 
        : null;
    $genre = isset($game['genres']) ? implode(", ", $game['genres']) : 'Unknown';
    $coverImageId = $game['cover']['image_id'] ?? null;
    $coverUrl = $coverImageId ? "https://images.igdb.com/igdb/image/upload/t_cover_big/{$coverImageId}.jpg" : "img/placeholder.jpg";

    // ✅ Extracting platform data
    $platforms = isset($game['platforms']) ? implode(", ", $game['platforms']) : "Unknown";

    try {
        // This checks if the game already exists in the database
        $stmt = $pdo->prepare("SELECT game_id FROM Game WHERE api_id = :api_id");
        $stmt->execute(['api_id' => $apiId]);
        $existingGame = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingGame) {
            
            $stmt = $pdo->prepare("
                UPDATE Game 
                SET title = :title, description = :description, genre = :genre, 
                    release_date = :release_date, platform = :platform, updated_at = NOW()
                WHERE api_id = :api_id
            ");
            $stmt->execute([
                'title' => $title,
                'description' => $description,
                'genre' => $genre,
                'release_date' => $releaseDate,
                'platform' => $platforms,
                'api_id' => $apiId,
            ]);
        } else {
            // Insert the new game
            $stmt = $pdo->prepare("
                INSERT INTO Game (title, description, genre, release_date, api_id, platform, created_at, updated_at) 
                VALUES (:title, :description, :genre, :release_date, :api_id, :platform, NOW(), NOW())
            ");
            $stmt->execute([
                'title' => $title,
                'description' => $description,
                'genre' => $genre,
                'release_date' => $releaseDate,
                'api_id' => $apiId,
                'platform' => $platforms,
            ]);
        }

        echo "Game {$title} processed successfully.<br>";
    } catch (PDOException $e) {
        echo "Error processing game {$title}: " . $e->getMessage() . "<br>";
    }
}

echo "All games processed successfully.";

?>
