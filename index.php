<?php

require_once __DIR__.'/src/Main.php';

use Ankit04\AviasalesFlight\AviasalesFlight;

$partnerId = '558305'; // marker
$apiToekn = '4660a93d4860614d6f4eae4af7a8f0fa';
$host = 'onelinktravel.com';


$user_ip = $_SERVER['REMOTE_ADDR'];
$user_ip = '103.182.161.48';
$locale = 'en';
$trip_class = 'Y';   // Y => 'econemy' , C  => 'Business. Required uppercase'
$adult = 1;
$children = 0;
$infants = 0;

$departure_date = "2024-08-21";
$arrival_date = "2024-08-28";
$origin = 'BOM';
$destination = 'YYC';

$passengers = [
                'adults'=> $adult,
                'children'=> $children,
                'infants'=> $infants,
                ];
$segments = [
                [
                    'origin' => $origin,
                    'destination' => $destination,
                    'date' => $departure_date,
                ],
                [
                    'origin' => $destination,
                    'destination' => $origin,
                    'date' => $arrival_date,
                ]
            ]; 
$data = [
    'user_ip' => $user_ip,
    'locale' => $locale,
    'trip_class' => $trip_class,
    'adult' => $adult,
    'children' => $children,
    'infants' => $infants,
    'departure_date' => $departure_date,
    'arrival_date' => $arrival_date,
    'origin' => $origin,
    'destination' => $destination,
];
AviasalesFlight::initiate($data);
