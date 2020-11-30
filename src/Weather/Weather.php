<?php

namespace Teca\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class Weather implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    private $url = 'api.openweathermap.org/data/2.5/';
    private $apiKey = '';

    public function setUrl(string $url) : void
    {
        $this->url = $url;
    }

    public function setApiKey(string $apiKey) : void
    {
        $this->apiKey = $apiKey;
    }

    protected function getCurrent(string $query) : array
    {
        $url = $this->url . "weather?q=" . $query . "&units=metric";

        if ($this->apiKey !== '') {
            $url .= '&appid=' . $this->apiKey;
        }

        $data = $this->curl($url);

        if ($data["cod"] !== 200) {
            return [];
        }

        return $data;
    }

    protected function getHistory(float $lon, float $lat) : array
    {
        $urls = [];
        for ($i=1; $i <= 5; $i++) {
            $time = time() - $i * 24 * 60 * 60;
            $url = $this->url . "onecall/timemachine?lat=$lat&lon=$lon&dt=$time&units=metric";

            if ($this->apiKey !== '') {
                $url .= '&appid=' . $this->apiKey;
            }

            $urls[] = $url;
        }

        return $this->mcurl($urls);
    }

    protected function data(int $day, string $weather, string $weatherDesc, float $temp) : array
    {
        return [
            "day" => $day,
            "weather" => $weather,
            "weatherDescription" => $weatherDesc,
            "temp" => $temp
        ];
    }

    public function getForecast(string $query) : array
    {
        $current = $this->getCurrent($query);
        if ($current == null) {
            return [
                "error" => true,
                "history" => [],
                "today" => [],
                "forecast" => [],
                "lon" => 0,
                "lat" => 0
            ];
        }

        $lon = $current["coord"]["lon"];
        $lat = $current["coord"]["lat"];

        $url = $this->url . "onecall?lat=$lat&lon=$lon&exclude=current,minutely,hourly,alerts&units=metric";

        if ($this->apiKey !== '') {
            $url .= '&appid=' . $this->apiKey;
        }

        $result = $this->curl($url);
        $forecast = [];
        foreach ($result["daily"] as $index => $day) {
            $forecast[] = $this->data($index + 1, $day["weather"][0]["main"], $day["weather"][0]["description"], $day["temp"]["day"]);
        }

        $today = $this->data(0, $current["weather"][0]["main"], $current["weather"][0]["description"], $current["main"]["temp"]);
        $history = $this->getHistory($lon, $lat);

        return [
            "error" => false,
            "history" => $history,
            "today" => $today,
            "forecast" => $forecast,
            "lon" => $lon,
            "lat" => $lat
        ];
    }

    protected function mcurl(array $urls) : array
    {
        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];

        $multiCurl = curl_multi_init();
        $requests = [];
        foreach ($urls as $url) {
            $curl = curl_init("$url");
            curl_setopt_array($curl, $options);
            curl_multi_add_handle($multiCurl, $curl);
            $requests[] = $curl;
        }

        $running = null;
        do {
            curl_multi_exec($multiCurl, $running);
        } while ($running);

        foreach ($requests as $curl) {
            curl_multi_remove_handle($multiCurl, $curl);
        }
        curl_multi_close($multiCurl);

        $response = [];
        foreach ($requests as $day => $curl) {
            $data = curl_multi_getcontent($curl);
            $data = json_decode($data, true);

            $index = sizeof($data["hourly"]);
            $midday = $data["hourly"][($index / 2) - 1];

            $response[] = $this->data(-$day - 1, $midday["weather"][0]["main"], $midday["weather"][0]["description"], $midday["temp"]);
        }

        return $response;
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
