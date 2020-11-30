# ramverk1-module

[![Build Status](https://travis-ci.org/Toddez/ramverk1-module.svg?branch=main)](https://travis-ci.org/Toddez/ramverk1-module)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Toddez/ramverk1-module/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/Toddez/ramverk1-module/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/Toddez/ramverk1-module/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/Toddez/ramverk1-module/?branch=main)

This module is part of the course *ramverk1* at *Blekinge Tekniska Högskola* and is being used for educational purposes.

## Installation

``composer require toddez/ramverk1-module``

## Configuration
The module uses two APIs: ipstack and OpenWeather. Both require keys to be configured in ``config/api.php``  

Example:
```php
<?php

return [
    "ipstackKey" => "secret key",
    "openweatherKey" => "secret key"
];
```
