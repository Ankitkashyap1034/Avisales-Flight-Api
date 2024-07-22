<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // your password
$dbname = "locations_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// cURL to fetch data
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.travelpayouts.com/data/en/cities.json",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    die("cURL Error #:" . $err);
}

// Decode JSON data
$data = json_decode($response, true);

// Check if JSON decoding was successful
if (json_last_error() !== JSON_ERROR_NONE) {
    die("JSON decoding error: " . json_last_error_msg());
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO locations (name_translations_en, cases_su, country_code, code, time_zone, name, coordinates_lat, coordinates_lon) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssdd", $nameTranslationsEn, $casesSu, $countryCode, $code, $timeZone, $name, $coordinatesLat, $coordinatesLon);

// Insert data
foreach ($data as $item) {
    $nameTranslationsEn = $item['name_translations']['en'];
    $casesSu = $item['cases']['su'];
    $countryCode = $item['country_code'];
    $code = $item['code'];
    $timeZone = $item['time_zone'];
    $name = $item['name'];
    $coordinatesLat = $item['coordinates']['lat'];
    $coordinatesLon = $item['coordinates']['lon'];

    $stmt->execute();
}

// Close connection
$stmt->close();
$conn->close();

echo "Data inserted successfully.";
?>
