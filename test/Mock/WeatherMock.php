<?php

namespace Teca\Weather;

class WeatherMock extends Weather
{
    protected function mcurl(array $urls) : array
    {
        return [
            [
                'day' => -1,
                'weather' => "Clouds",
                'weatherDescription' => "overcast clouds",
                'temp' => 7.01
            ],
            [
                'day' => -2,
                'weather' => "Rain",
                'weatherDescription' => "light rain",
                'temp' => 9.82
            ],
            [
                'day' => -3,
                'weather' => "Clear",
                'weatherDescription' => "clear sky",
                'temp' => 14.84
            ],
            [
                'day' => -4,
                'weather' => "Clouds",
                'weatherDescription' => "broken clouds",
                'temp' => 13.74
            ],
            [
                'day' => -5,
                'weather' => "Clouds",
                'weatherDescription' => "broken clouds",
                'temp' => 10.12
            ]
        ];
    }

    protected function curl(string $url) : array
    {
        if ($url === "weather?q=London&units=metric") {
            return [
                "coord" => [
                    "lon" => -0.13,
                    "lat" => 51.51
                ],
                "weather" => [
                    [
                        "main" => "Clouds",
                        "description" => "overcast clouds",
                    ]
                ],
                "main" => [
                    "temp" => 12.31
                ],
                "cod" => 200
            ];
        }

        if ($url === "onecall?lat=51.51&lon=-0.13&exclude=current,minutely,hourly,alerts&units=metric") {
            return [
                "daily" => [
                    [
                        "weather" => [
                            [
                                "main" => "Clouds",
                                "description" => "overcast clouds",
                            ]
                        ],
                        "temp" => [
                            "day" => 12.31
                        ]
                    ],
                ]
            ];
        }

        return [];
    }
}
