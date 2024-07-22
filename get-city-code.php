<?php

function getIATACode($city, $country) {
    $url = "https://api.travelpayouts.com/data/en/cities.json";
    
    $response = file_get_contents($url);
    if ($response === FALSE) {
        die('Error occurred while fetching data.');
    }

    $cities = json_decode($response, true);

    foreach ($cities as $cityData) {
        // Check the keys to ensure they match the JSON structure
        if (
            isset($cityData['name']) &&
            isset($cityData['country_code']) &&
            strcasecmp($cityData['name'], $city) == 0 &&
            strcasecmp($cityData['country_code'], $country) == 0
        ) {
            return strtoupper($cityData['code']);
        }
    }

    return null;
}

function formatOrigin($city, $country, $iata) {
    return "{$city}, {$country} (" . strtoupper($iata) . ")";
}

// Example usage
$city = "Cape Young";
$country = "CA";
$iata = getIATACode($city, $country);

if ($iata) {
    echo formatOrigin($city, $country, $iata);
} else {
    echo "IATA code not found.";
}
