<?php

namespace Ankit04\AviasalesFlight\Http;

class Crul
{    
    public static function get_search_id($data)
    {
        // Endpoint URL
        $url = 'http://api.travelpayouts.com/v1/flight_search';


        // Encode the data into JSON format
        $json_data = json_encode($data);

        // Initialize cURL
        $ch = curl_init($url);

        // Set the options for cURL
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_data)
        ));

        // Execute the POST request
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            die('Error: ' . $error);
        }

        // Close cURL
        curl_close($ch);

        echo "<pre>";
        print_r($response);
        die;
        // Print the response
        // echo 'Response: ' . $response;
    }
}