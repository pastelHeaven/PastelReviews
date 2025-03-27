<?php
// this file 
header("Content-Type: application/json");

$accessToken = 'arxqn51p65ej84xlt4seqd3ycgnwup'; 
$clientId = 'y0bo6jm5v1km9xwv984yffs62vnrkk';

$apiId = isset($_GET['game_id']) ? $_GET['game_id'] : null;

if ($gameId) {

    $url = "https://api.igdb.com/v4/games";
    $requestBody = "fields name, cover.image_id, genres.name, platforms.name, first_release_date, summary; where id = $apiId;";

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

    if (curl_errno($ch)) {
        echo json_encode(["error" => "Error fetching data from IGDB: " . curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    curl_close($ch);
    echo $response;
} else {

    $url = "https://api.igdb.com/v4/games";
    $requestBody = "fields name, cover.image_id; limit 20;";

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

    if (curl_errno($ch)) {
        echo json_encode(["error" => "Error fetching data from IGDB: " . curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    curl_close($ch);
    echo $response;
}

?>
