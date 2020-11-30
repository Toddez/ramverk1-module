<?php
/**
 * Load the controller
 */
return [
    "routes" => [
        [
            "info" => "Väder API.",
            "mount" => "weatherapi",
            "handler" => "\Teca\Weather\WeatherAPIController",
        ],
    ]
];
