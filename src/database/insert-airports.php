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
    CURLOPT_URL => "https://gist.githubusercontent.com/tdreyno/4278655/raw/7b0762c09b519f40397e4c3e100b097d861f5588/airports.json", // Replace with the actual API endpoint
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
$stmt = $conn->prepare("INSERT INTO airports (code, lat, lon, name, city, state, country, woeid, tz, phone, type, email, url, runway_length, elev, icao, direct_flights, carriers) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sddssssssssssiisii", $code, $lat, $lon, $name, $city, $state, $country, $woeid, $tz, $phone, $type, $email, $url, $runway_length, $elev, $icao, $direct_flights, $carriers);

// Insert data
foreach ($data as $item) {
    $code = $item['code'];
    $lat = $item['lat'];
    $lon = $item['lon'];
    $name = $item['name'];
    $city = $item['city'];
    $state = $item['state'];
    $country = $item['country'];
    $woeid = $item['woeid'];
    $tz = $item['tz'];
    $phone = $item['phone'];
    $type = $item['type'];
    $email = $item['email'];
    $url = $item['url'];
    $runway_length = $item['runway_length'];
    $elev = $item['elev'];
    $icao = $item['icao'];
    $direct_flights = $item['direct_flights'];
    $carriers = $item['carriers'];

    $stmt->execute();
}

// Close connection
$stmt->close();
$conn->close();

echo "Data inserted successfully.";
?>
