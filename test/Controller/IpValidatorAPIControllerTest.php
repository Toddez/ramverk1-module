<?php

namespace Teca\IpValidator;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

class IpValidatorAPIControllerTest extends TestCase
{
    protected $di;
    protected $controller;

    protected function setUp()
    {
        global $di;

        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        $di = $this->di;

        $this->controller = new IpValidatorAPIControllerMock();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }

    public function testIndexAction()
    {
        $ipAdress = "127.0.0.1";

        $this->di->get("request")->setPost("ip", $ipAdress);

        $res = $this->controller->indexActionPost();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $this->assertEquals($json["ip"], $ipAdress);
        $this->assertEquals($json["ipv4"], true);
        $this->assertEquals($json["ipv6"], false);
        $this->assertEquals($json["domain"], "localhost");
    }
}
