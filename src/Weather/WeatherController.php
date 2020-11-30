<?php

namespace Teca\Weather;

use Anax\DI\DIFactoryConfig;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    protected $weather = null;
    protected $validator = null;

    public function initialize()
    {
        $this->weather = $this->di->get("weather");
        $this->validator = $this->di->get("ipValidator");
    }

    public function toc() : array
    {
        return [
            "toc" => [
                "weather" => [
                    "sectionHeader" => true,
                    "title" => "info",
                    "linkable" => true,
                    "level" => 1
                ],
                "weather/forms" => [
                    "sectionHeader" => true,
                    "title" => "Formulär",
                    "linkable" => false,
                    "level" => 1
                ],
                "weather/form" => [
                    "sectionHeader" => false,
                    "title" => "väder",
                    "linkable" => true,
                    "level" => 1
                ],
                "weather/json" => [
                    "sectionHeader" => false,
                    "title" => "väder API",
                    "linkable" => true,
                    "level" => 1
                ]
            ],
            "title" => "Väder"
        ];
    }

    public function indexAction() : object
    {
        $page = $this->di->get("page");

        $page->add("anax/v2/toc/default", $this->toc());
        $page->add("Weather/info", []);

        return $page->render([
            "title" => "Väder information",
        ]);
    }

    public function formAction() : object
    {
        $page = $this->di->get("page");

        $page->add("anax/v2/toc/default", $this->toc());
        $page->add("Weather/form", [
            "action" => "../weather/verify",
            "method" => "GET",
        ]);

        return $page->render([
            "title" => "Väder",
        ]);
    }

    public function jsonActionGet() : object
    {
        $page = $this->di->get("page");

        $page->add("anax/v2/toc/default", $this->toc());
        $page->add("Weather/form", [
            "title" => "Väder JSON",
            "text" => "Formuläret skickar en POST request som sedan visas i webbläsaren som rå JSON. Mer <a href=\"./\">info</a>.",
            "action" => "../weatherapi",
            "method" => "POST"
        ]);

        return $page->render([
            "title" => "(JSON) Väder",
        ]);
    }

    public function verifyAction() : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        $query = $request->getGet("query");

        $geo = $this->validator->getGeo($query);

        if ($geo["city"] !== null) {
            $query = $geo["city"];
        }

        $forecast = $this->weather->getForecast($query);

        $page->add("anax/v2/toc/default", $this->toc());
        $page->add("Weather/result", [
            "error" => $forecast["error"],
            "history" => $forecast["history"],
            "today" => $forecast["today"],
            "forecast" => $forecast["forecast"],
            "query" => $query,
            "lon" => $forecast["lon"],
            "lat" => $forecast["lat"],
            "geo" => $geo
        ]);

        return $page->render([
            "title" => "Resultat av Väder sökning",
        ]);
    }
}
