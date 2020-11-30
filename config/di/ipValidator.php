<?php

return [
    "services" => [
        "ipValidator" => [
            "callback" => function () {
                $service = new \Teca\IpValidator\IpValidator();
                $service->setDi($this);

                $cfg = $this->get('configuration');
                try {
                    $config = $cfg->load('api.php');
                    $settings = $config['config'] ?? null;
                    $service->setApiKey($settings['ipstackKey']);
                } catch (\Exception $e) {
                    if (!empty(getenv('ipstackKey'))) {
                        $service->setApiKey(getenv('ipstackKey'));
                    } else {
                        $service->setApiKey('');
                    }
                }

                return $service;
            }
        ],
    ],
];
