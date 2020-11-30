<?php

namespace Anax\View;

?><h3>Ipvalidator</h3>

<h4>Resultat</h4>

<div class="ip-validator-result">
    <div class="ip-validator-result-ip">
        IP: <?= htmlentities($ip) ?: "Ingen IP adress given" ?>
    </div>
    <div class="ip-validator-result-ipv4">
        Är giltig IPv4: <?= $ipv4 ? "Ja" : "Nej" ?>
    </div>
    <div class="ip-validator-result-ipv6">
        Är giltig IPv6: <?= $ipv6 ? "Ja" : "Nej" ?>
    </div>
    <div class="ip-validator-result-domain">
        Domän: <?= $domain ?: "Ingen domän" ?>
    </div>
    <br>
    <div class="ip-validator-result-geo">
        Latitude: <?= $latitude ?: "saknas" ?><br>
        Longitude: <?= $longitude ?: "saknas" ?><br>
        Land: <?= $country_name ?: "saknas" ?><br>
        Region: <?= $region_name ?: "saknas" ?><br>
        Stad: <?= $city ?: "saknas" ?>
    </div>

    <a href="../ipvalidator/form">Validera annan IP</a>
</div>
