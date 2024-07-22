<?php

namespace Ankit04\AviasalesFlight;

// including files
require __DIR__.'/config.php';
require __DIR__.'/Http/Crul.php';


use Ankit04\AviasalesFlight\Http\Crul;

class AviasalesFlight
{

    public static function initiate($data)
    {
        
        $user_ip = $data['user_ip'];
        $locale = $data['locale'];
        $trip_class = $data['trip_class'];
        $adult = $data['adult'];
        $children = $data['children'];
        $infants = $data['infants'];
        $departure_date = $data['departure_date'];
        $arrival_date = $data['arrival_date'];
        $origin = $data['origin'];
        $destination = $data['destination'];
        

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

        $plain_signature = __API_TOEKN__.':'.__HOST__.':'.$locale.':'.__MARKER__.':'.$adult.':'.$children.':'.$infants.':'.$departure_date.':'.$destination.':'.$origin.':'.$arrival_date.':'.$destination.':'.$origin.':'.$trip_class.':'.$user_ip;
        $signature = md5_genrate($plain_signature);     
        
        $data = array(
            "signature" => $signature,
            "marker" => __MARKER__,
            "host" => __HOST__,
            "user_ip" => $user_ip,
            "locale" => $locale,
            "trip_class" => $trip_class,
            $passengers,
            $segments,
        );

        Crul::get_search_id($data);


    }

    
}