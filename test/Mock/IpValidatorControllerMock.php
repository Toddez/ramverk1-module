<?php

namespace Teca\IpValidator;

use Teca\IpValidator;

class IpValidatorControllerMock extends IpValidatorController
{
    public function initialize()
    {
        $this->validator = new IpValidatorMock();
        $this->validator->setUrl('');
        $this->validator->setApiKey('');
    }
}
