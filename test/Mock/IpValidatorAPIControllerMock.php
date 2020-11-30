<?php

namespace Teca\IpValidator;

use Teca\IpValidator;

class IpValidatorAPIControllerMock extends IpValidatorAPIController
{
    public function initialize()
    {
        $this->validator = new IpValidatorMock();
        $this->validator->setUrl('');
        $this->validator->setApiKey('');
    }
}
