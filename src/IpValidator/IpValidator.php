<?php

namespace Teca\IpValidator;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class IpValidator implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    private $url = 'http://api.ipstack.com/';
    private $apiKey = '';

    public function setUrl(string $url) : void
    {
        $this->url = $url;
    }

    public function setApiKey(string $apiKey) : void
    {
        $this->apiKey = $apiKey;
    }

    public function verifyIpv4(string $ipAddress) : bool
    {
        return filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    public function verifyIpv6(string $ipAddress) : bool
    {
        return filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }

    public function getDomain(string $ipAddress) : string
    {
        if (!$this->verifyIpv4($ipAddress) && !$this->verifyIpv6($ipAddress)) {
            return "";
        }

        $host = gethostbyaddr($ipAddress);
        return $host !== $ipAddress ? $host : "";
    }

    protected function noGeo() : array
    {
        return [
            "latitude" => null,
            "longitude" => null,
            "country_name" => null,
            "region_name" => null,
            "city" => null
        ];
    }

    public function getGeo(string $ipAddress) : array
    {
        if (!$this->verifyIpv4($ipAddress) && !$this->verifyIpv6($ipAddress)) {
            return $this->noGeo();
        }

        $url = $this->url . $ipAddress;

        if ($this->apiKey !== '') {
            $url .= '?access_key=' . $this->apiKey;
        }

        $data = $this->curl($url);

        return $data;
    }

    protected function curl(string $url) : array
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);

        $data = curl_exec($curl);
        curl_close($curl);

        return json_decode($data, true);
    }
}
