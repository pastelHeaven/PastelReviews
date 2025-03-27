<?php

// this is just testing diffrent api from rapdi api website as some of the api on tehir 
// website are outdated oy not in used anymore
$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://mmo-games.p.rapidapi.com/latestnews",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: mmo-games.p.rapidapi.com",
		"x-rapidapi-key: 21ddba5682msh29223c324433019p1a53fajsn2b5a3606d827"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}