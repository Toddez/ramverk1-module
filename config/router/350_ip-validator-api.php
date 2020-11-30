<?php
/**
 * Load the controller
 */
return [
    "routes" => [
        [
            "info" => "IP Validator API.",
            "mount" => "ipvalidatorapi",
            "handler" => "\Teca\IpValidator\IpValidatorAPIController",
        ],
    ]
];
