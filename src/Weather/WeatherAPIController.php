<?php

namespace Teca\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class WeatherAPIController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    protected $weather = null;
    protected $validator = null;

    public function initialize()
    {
        $this->weather = $this->di->get("weather");
        $this->validator = $this->di->get("ipValidator");
    }

    public function indexActionPost() : array
    {
        $request = $this->di->get("request");
        $query = $request->getPost("query");

        $geo = $this->validator->getGeo($query);

        if ($geo["city"] !== null) {
            $query = $geo["city"];
        }

        $forecast = $this->weather->getForecast($query);

        $json = [
            "error" => $forecast["error"],
            "country_name" => $geo["country_name"],
            "region_name" => $geo["region_name"],
            "query" => $query,
            "history" => $forecast["history"],
            "today" => $forecast["today"],
            "forecast" => $forecast["forecast"]
        ];

        return [$json];
    }
}
