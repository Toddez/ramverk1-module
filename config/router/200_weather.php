<?php
/**
 * Load the controller
 */
return [
    "routes" => [
        [
            "info" => "Väder.",
            "mount" => "weather",
            "handler" => "\Teca\Weather\WeatherController",
        ],
    ]
];
