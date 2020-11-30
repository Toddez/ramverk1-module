<?php

namespace Teca\IpValidator;

class IpValidatorMock extends IpValidator
{
    protected function curl(string $url) : array
    {
        return $this->noGeo();
    }
}
