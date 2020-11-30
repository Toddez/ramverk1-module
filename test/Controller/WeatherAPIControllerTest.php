<?php

namespace Teca\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

class WeatherAPIControllerTest extends TestCase
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

        $this->controller = new WeatherAPIControllerMock();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }

    public function testIndexAction()
    {
        $query = "London";

        $this->di->get("request")->setPost("query", $query);

        $res = $this->controller->indexActionPost();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $this->assertEquals($json["error"], false);
        $this->assertEquals($json["query"], $query);

        $this->assertInternalType("array", $json["history"]);
        $this->assertEquals(sizeof($json["history"]), 5);

        $this->assertInternalType("array", $json["today"]);

        $this->assertInternalType("array", $json["forecast"]);
        $this->assertEquals(sizeof($json["forecast"]), 1);
    }
}
