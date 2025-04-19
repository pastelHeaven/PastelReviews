<!-- //this file is used to fetch the latest reviews from the database and return them as a JSON response, this is used in the home page 
to display the latest reviews -->
<?php 


require_once "conDatabase.php"; 
if (!isset($pdo)) {
    die("Database connection error.");
}
// this fetches the latest reviews from the database
$query = "SELECT r.comment, r.rating, r.platform, u.username, r.created_at 
          FROM Review r
          JOIN users u ON r.user_id = u.id";
          //
$stmt = $pdo->prepare($query);
$stmt->execute();
$review = $stmt->fetchAll(PDO::FETCH_ASSOC);
// this will return the latest reviews in a json format to be used in the home page
header('Content-Type: application/json');
echo json_encode($review);



?>