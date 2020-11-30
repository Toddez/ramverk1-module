<?php
/**
 * Load the controller
 */
return [
    "routes" => [
        [
            "info" => "IP Validator.",
            "mount" => "ipvalidator",
            "handler" => "\Teca\IpValidator\IpValidatorController",
        ],
    ]
];
