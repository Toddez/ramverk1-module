<?php

namespace Teca\Weather;

use Teca\IpValidator;
use Teca\IpValidator\IpValidatorMock;

class WeatherControllerMock extends WeatherController
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
