<?php

namespace Teca\Weather;

use Teca\Weather;
use Teca\IpValidator\IpValidatorMock;

class WeatherAPIControllerMock extends WeatherAPIController
{
    public function initialize()
    {
        $this->validator = new IpValidatorMock();
        $this->validator->setUrl('');
        $this->validator->setApiKey('');

        $this->weather = new WeatherMock();
        $this->weather->setUrl('');
        $this->weather->setApiKey('');
    }
}
