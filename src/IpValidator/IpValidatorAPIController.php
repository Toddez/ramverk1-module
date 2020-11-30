<?php

namespace Teca\IpValidator;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class IpValidatorAPIController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    protected $validator = null;

    public function initialize()
    {
        $this->validator = $this->di->get("ipValidator");
    }

    public function indexActionPost() : array
    {
        $request = $this->di->get("request");
        $ipAddress = $request->getPost("ip");

        $geo = $this->validator->getGeo($ipAddress);

        $json = [
            "ip" => $ipAddress,
            "ipv4" => $this->validator->verifyIpv4($ipAddress),
            "ipv6" => $this->validator->verifyIpv6($ipAddress),
            "domain" => $this->validator->getDomain($ipAddress),
            "latitude" => $geo["latitude"],
            "longitude" => $geo["longitude"],
            "country_name" => $geo["country_name"],
            "region_name" => $geo["region_name"],
            "city" => $geo["city"]
        ];

        return [$json];
    }
}
