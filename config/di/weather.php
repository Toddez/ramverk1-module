<?php

return [
    "services" => [
        "weather" => [
            "callback" => function () {
                $service = new \Teca\Weather\Weather();
                $service->setDi($this);

                $cfg = $this->get('configuration');
                try {
                    $config = $cfg->load('api.php');
                    $settings = $config['config'] ?? null;
                    $service->setApiKey($settings['openweatherKey']);
                } catch (\Exception $e) {
                    if (!empty(getenv('openweatherKey'))) {
                        $service->setApiKey(getenv('openweatherKey'));
                    } else {
                        $service->setApiKey('');
                    }
                }

                return $service;
            }
        ],
    ],
];
