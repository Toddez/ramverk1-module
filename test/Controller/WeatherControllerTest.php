<?php

namespace Teca\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
use Teca\IpValidator\IpValidatorMock;

class WeatherControllerTest extends TestCase
{
    protected $di;
    protected $controller;
    protected $validator;
    protected $weather;

    protected function setUp()
    {
        global $di;

        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        $di = $this->di;

        $this->controller = new WeatherControllerMock();
        $this->controller->setDI($this->di);
        $this->controller->initialize();

        $this->validator = new IpValidatorMock();
        $this->validator->setUrl('');
        $this->validator->setApiKey('');

        $this->weather = new WeatherMock();
        $this->weather->setUrl('');
        $this->weather->setApiKey('');
    }

    public function testToc()
    {
        $res = $this->controller->toc();
        $this->assertInternalType("array", $res);
    }

    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();

        $this->assertContains("<title>Väder information", $body);
        $this->assertContains("<h4>Information", $body);
        $this->assertContains("<h5>JSON API", $body);
    }

    public function testFormAction()
    {
        $res = $this->controller->formAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();

        $this->assertContains("<title>Väder", $body);
        $this->assertContains("<h3>Väder", $body);
        $this->assertContains("<form action=\"../weather/verify\" method=\"GET", $body);
    }

    public function testJsonAction()
    {
        $res = $this->controller->jsonActionGet();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();

        $this->assertContains("<title>(JSON) Väder", $body);
        $this->assertContains("<h3>Väder JSON", $body);
        $this->assertContains("<form action=\"../weatherapi\" method=\"POST", $body);
    }

    public function testVerifyAction()
    {
        $query = "London";

        $this->di->get("request")->setGet("query", $query);

        $res = $this->controller->verifyAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();

        $this->assertContains("<title>Resultat", $body);
        $this->assertContains("<h4>Resultat för söksträngen: London", $body);
        $this->assertContains("<div id=\"map\"", $body);
        $this->assertContains("<h5>Dagens väder", $body);
        $this->assertContains("<h5>Föregående väder", $body);
        $this->assertContains("<h5>Kommande väder", $body);
    }
}
