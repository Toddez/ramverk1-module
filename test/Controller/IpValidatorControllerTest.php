<?php

namespace Teca\IpValidator;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

class IpValidatorControllerTest extends TestCase
{
    protected $di;
    protected $controller;
    protected $validator;

    protected function setUp()
    {
        global $di;

        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        $di = $this->di;

        $this->controller = new IpValidatorControllerMock();
        $this->controller->setDI($this->di);
        $this->controller->initialize();

        $this->validator = new IpValidatorMock();
        $this->validator->setUrl('');
        $this->validator->setApiKey('');
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

        $this->assertContains("<title>IP Validator Info", $body);
        $this->assertContains("<h4>Information", $body);
        $this->assertContains("<h5>JSON API", $body);
    }

    public function testFormAction()
    {
        $res = $this->controller->formAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();

        $this->assertContains("<title>Validera IP", $body);
        $this->assertContains("<h3>IP Validator", $body);
        $this->assertContains("<form action=\"../ipvalidator/verify\" method=\"GET", $body);
    }

    public function testJsonAction()
    {
        $res = $this->controller->jsonActionGet();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();

        $this->assertContains("<title>(JSON) Validera IP", $body);
        $this->assertContains("<h3>IP Validator JSON", $body);
        $this->assertContains("<form action=\"../ipvalidatorapi\" method=\"POST", $body);
    }

    public function testVerifyAction()
    {
        $ipAdress = "127.0.0.1";

        $this->di->get("request")->setGet("ip", $ipAdress);

        $res = $this->controller->verifyAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();

        $this->assertContains("<title>Resultat", $body);
        $this->validateResult($ipAdress, $body);
    }

    public function testTest0Action()
    {
        $ipAdress = "127.0.0.1";

        $res = $this->controller->test0Action();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $this->assertEquals($json["ip"], $ipAdress);
        $this->assertEquals($json["ipv4"], true);
        $this->assertEquals($json["ipv6"], false);
        $this->assertEquals($json["domain"], "localhost");
    }

    public function testTest1Action()
    {
        $ipAdress = "194.47.150.9";

        $res = $this->controller->test1Action();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $this->assertEquals($json["ip"], $ipAdress);
        $this->assertEquals($json["ipv4"], true);
        $this->assertEquals($json["ipv6"], false);
    }

    public function testTest2Action()
    {
        $ipAdress = "2a00:1450:400f:808::2003";

        $res = $this->controller->test2Action();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $this->assertEquals($json["ip"], $ipAdress);
        $this->assertEquals($json["ipv4"], false);
        $this->assertEquals($json["ipv6"], true);
    }

    public function testTest3Action()
    {
        $ipAdress = "256.256.256.256";

        $res = $this->controller->test3Action();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $this->assertEquals($json["ip"], $ipAdress);
        $this->assertEquals($json["ipv4"], false);
        $this->assertEquals($json["ipv6"], false);
    }

    private function validateResult($ipAdress, $body)
    {
        $this->assertContains("<h4>Resultat", $body);
        $this->assertContains("IP: " . $ipAdress, $body);
        $this->assertContains("IPv4: " . ($this->validator->verifyIpv4($ipAdress) ? "Ja" : "Nej"), $body);
        $this->assertContains("IPv6: " . ($this->validator->verifyIpv6($ipAdress) ? "Ja" : "Nej"), $body);
        $this->assertContains("Domän: ", $body);
    }
}
