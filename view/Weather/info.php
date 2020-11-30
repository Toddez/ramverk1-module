<?php

namespace Anax\View;

?><h3>Väder</h3>

<h4>Information</h4>

<p>
    Ovanför hittar du ett antal länkar:
    <li>Info: Denna sidan du läser just nu.</li>
    <li>Formulär för att kolla upp väder (Både med standard controller och JSON API:et).</li>
</p>

<h5>JSON API</h5>
<p>
    JSON API:et svarar på <code>POST: /weatherjson</code> och förväntar sig en body med nyckeln: <code>query</code><br>
    <code>query</code> kan vara en ip adress eller t.ex. en stad
</p>

<p>
    <b>Exempel</b><br>
    <code>{ "query": "194.47.150.9" }</code> till <code>POST: /weatherjson</code> ger svaret:<br>
    <pre>
        <code>{
    "error": false,
    "country_name": "Sweden",
    "region_name": "Blekinge",
    "query": "Karlskrona",
    "history": [
        {
            "day": -1,
            "weather": "Rain",
            "weatherDescription": "light rain",
            "temp": 9.82
        },
        {
            "day": -2,
            "weather": "Clear",
            "weatherDescription": "clear sky",
            "temp": 14.84
        },
        ...
    ],
    "today": {
        "day": 0,
        "weather": "Rain",
        "weatherDescription": "light rain",
        "temp": 8.78
    },
    "forecast": [
        {
            "day": 1,
            "weather": "Rain",
            "weatherDescription": "light rain",
            "temp": 8.75
        },
        {
            "day": 2,
            "weather": "Clouds",
            "weatherDescription": "overcast clouds",
            "temp": 11.68
        },
        ...
    ]
}</code>
    </pre>
</p>

<h5>JSON Formulär</h5>
<p>Enligt kvarspecen så skall JSON formuläret <b>POST:a</b> och sedan visa upp svaret direkt i <b>JSON</b>. Därför renderas inte någon vy efter man skickar POST:en, utan svaret visas upp i webbläsaren som rå JSON.</p>
