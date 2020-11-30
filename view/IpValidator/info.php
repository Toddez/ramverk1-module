<?php

namespace Anax\View;

?><h3>Ipvalidator</h3>

<h4>Information</h4>

<p>
    Ovanför hittar du ett antal länkar:
    <li>Info: Denna sidan du läser just nu.</li>
    <li>Formulär för att validera en IP adress (Både med standard controller och JSON API:et).</li>
    <li>Tester för ett antal olika förinställda IP adresser.</li>
</p>

<h5>JSON API</h5>
<p>
    JSON API:et svarar på <code>POST: /ipvalidatorjson</code> och förväntar sig en body med nyckeln: <code>ip</code>
</p>

<p>
    <b>Exempel</b><br>
    <code>{ "ip": "194.47.150.9" }</code> till <code>POST: /ipvalidatorjson</code> ger svaret:<br>
    <pre>
        <code>{
    "ip": "194.47.150.9",
    "ipv4": true,
    "ipv6": false,
    "domain": "dbwebb.se",
    "latitude": 56.16122055053711,
    "longitude": 15.586899757385254,
    "country_name": "Sweden",
    "region_name": "Blekinge",
    "city": "Karlskrona"
}</code>
    </pre>
</p>

<h5>JSON Formulär</h5>
<p>Enligt kvarspecen så skall JSON formuläret <b>POST:a</b> och sedan visa upp svaret direkt i <b>JSON</b>. Därför renderas inte någon vy efter man skickar POST:en, utan svaret visas upp i webbläsaren som rå JSON.</p>
