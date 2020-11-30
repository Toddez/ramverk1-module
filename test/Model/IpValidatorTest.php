<?php

namespace Teca\IpValidator;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

class IpValidatorTest extends TestCase
{
    protected $di;
    protected $model;

    protected function setUp()
    {
        global $di;

        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        $di = $this->di;

        $this->model = new IpValidatorMock();
        $this->model->setUrl('');
        $this->model->setApiKey('');
    }

    public function testIpv4()
    {
        // Valid
        $this->assertTrue($this->model->verifyIpv4("127.0.0.1"));

        // Invalid
        $this->assertFalse($this->model->verifyIpv4("256.0.0.1"));
    }

    public function testIpv6()
    {
        // Long
        $this->assertTrue($this->model->verifyIpv6("0000:0000:0000:0000:0000:0000:0000:0001"));

        // Short
        $this->assertTrue($this->model->verifyIpv6("0123::4567:89ab:cdef:ffff"));

        // Invalid
        $this->assertFalse($this->model->verifyIpv6("g000::0000:0000:0000:0000"));
    }

    public function testDomain()
    {
        $this->assertEquals($this->model->getDomain("127.0.0.1"), "localhost");
        $this->assertEquals($this->model->getDomain("256.0.0.1"), "");
    }
}
