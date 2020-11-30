<?php

namespace Teca\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

class WeatherTest extends TestCase
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

        $this->model = new WeatherMock();
        $this->model->setUrl('');
        $this->model->setApiKey('');
    }

    public function testGetForecast()
    {
        $forecast = $this->model->getForecast("London");
        $this->assertArrayHasKey("history", $forecast);
        $this->assertArrayHasKey("today", $forecast);
        $this->assertArrayHasKey("forecast", $forecast);
        $this->assertArrayHasKey("lon", $forecast);
        $this->assertArrayHasKey("lat", $forecast);

        $this->assertFalse($forecast["error"]);
    }
}
