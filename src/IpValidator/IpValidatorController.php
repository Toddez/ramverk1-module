<?php

namespace Teca\IpValidator;

use Anax\DI\DIFactoryConfig;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class IpValidatorController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    protected $validator = null;

    public function initialize()
    {
        $this->validator = $this->di->get("ipValidator");
    }

    public function toc() : array
    {
        return [
            "toc" => [
                "ipvalidator" => [
                    "sectionHeader" => true,
                    "title" => "info",
                    "linkable" => true,
                    "level" => 1
                ],
                "ipvalidator/forms" => [
                    "sectionHeader" => true,
                    "title" => "Formulär",
                    "linkable" => false,
                    "level" => 1
                ],
                "ipvalidator/form" => [
                    "sectionHeader" => false,
                    "title" => "ip validator",
                    "linkable" => true,
                    "level" => 1
                ],
                "ipvalidator/json" => [
                    "sectionHeader" => false,
                    "title" => "ip validator API",
                    "linkable" => true,
                    "level" => 1
                ],
                "ipvalidator/test" => [
                    "sectionHeader" => true,
                    "title" => "Tester av API",
                    "linkable" => false,
                    "level" => 1
                ],
                "ipvalidator/test0" => [
                    "sectionHeader" => false,
                    "title" => "test0: IPv4 - localhost",
                    "linkable" => true,
                    "level" => 1
                ],
                "ipvalidator/test1" => [
                    "sectionHeader" => false,
                    "title" => "test1: IPv4 - dbwebb.se",
                    "linkable" => true,
                    "level" => 1
                ],
                "ipvalidator/test2" => [
                    "sectionHeader" => false,
                    "title" => "test2: IPv6 - google.se",
                    "linkable" => true,
                    "level" => 1
                ],
                "ipvalidator/test3" => [
                    "sectionHeader" => false,
                    "title" => "test3: Ogiltig IP adress",
                    "linkable" => true,
                    "level" => 1
                ]
            ],
            "title" => "IP Validering"
        ];
    }

    public function indexAction() : object
    {
        $page = $this->di->get("page");

        $page->add("anax/v2/toc/default", $this->toc());
        $page->add("IpValidator/info", []);

        return $page->render([
            "title" => "IP Validator Info",
        ]);
    }

    public function formAction() : object
    {
        $page = $this->di->get("page");

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipAddress = "";
        }

        $page->add("anax/v2/toc/default", $this->toc());
        $page->add("IpValidator/form", [
            "action" => "../ipvalidator/verify",
            "method" => "GET",
            "ipAddress" => $ipAddress
        ]);

        return $page->render([
            "title" => "Validera IP",
        ]);
    }

    public function jsonActionGet() : object
    {
        $page = $this->di->get("page");

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipAddress = "";
        }

        $page->add("anax/v2/toc/default", $this->toc());
        $page->add("IpValidator/form", [
            "title" => "IP Validator JSON",
            "text" => "Formuläret skickar en POST request som sedan visas i webbläsaren som rå JSON. Mer <a href=\"./\">info</a>.",
            "action" => "../ipvalidatorapi",
            "method" => "POST",
            "ipAddress" => $ipAddress
        ]);

        return $page->render([
            "title" => "(JSON) Validera IP",
        ]);
    }

    public function verifyAction() : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");

        $ipAddress = $request->getGet("ip");

        $geo = $this->validator->getGeo($ipAddress);

        $page->add("anax/v2/toc/default", $this->toc());
        $page->add("IpValidator/result", [
            "ip" => $ipAddress,
            "ipv4" => $this->validator->verifyIpv4($ipAddress),
            "ipv6" => $this->validator->verifyIpv6($ipAddress),
            "domain" => $this->validator->getDomain($ipAddress),
            "latitude" => $geo["latitude"],
            "longitude" => $geo["longitude"],
            "country_name" => $geo["country_name"],
            "region_name" => $geo["region_name"],
            "city" => $geo["city"]
        ]);

        return $page->render([
            "title" => "Resultat av IP validering",
        ]);
    }

    public function test(string $ipAddress) : array
    {
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

    public function test0Action() : array
    {
        $ipAddress = "127.0.0.1";
        return $this->test($ipAddress);
    }

    public function test1Action() : array
    {
        $ipAddress = "194.47.150.9";
        return $this->test($ipAddress);
    }

    public function test2Action() : array
    {
        $ipAddress = "2a00:1450:400f:808::2003";
        return $this->test($ipAddress);
    }

    public function test3Action() : array
    {
        $ipAddress = "256.256.256.256";
        return $this->test($ipAddress);
    }
}
