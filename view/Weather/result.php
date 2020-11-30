<?php

namespace Anax\View;

?><h3>Väder</h3>

<h4>Resultat för söksträngen: <?= $query ?></h4>

<?php if ($error) { ?>
    <p>Kunde inte hitta väder för söksträngen: <?= $query ?></p>
<?php } else { ?>
    <h5>Plats</h5>
    <p><?= $geo["country_name"] ?></p>
    <p><?= $geo["region_name"] ?></p>
    <p><?= $query ?></p>
    <div id="map" style="width: 100%; height: 500px;"></div>
    <h5>Dagens väder</h5>
    <span><?= $today["weather"] ?></span> - 
    <span><i><?= $today["weatherDescription"] ?></i></span><br>
    <span><?= $today["temp"] ?> grader</span>

    <h5>Föregående väder</h5>
    <table>
        <tr><th>Dagar bakåt</th><th>Väder</th><th>Temperatur</th></tr>
        <?php foreach ($history as $index => $day) { ?>
            <tr><td><?= $index + 1 ?></td><td><?= $day["weather"] ?> - <i><?= $day["weatherDescription"] ?></i></td><td><?= $day["temp"] ?> grader</td></tr>
        <?php } ?>
    </table>

    <h5>Kommande väder</h5>
    <table>
        <tr><th>Dagar frammåt</th><th>Väder</th><th>Temperatur</th></tr>
        <?php foreach ($forecast as $index => $day) { ?>
            <tr><td><?= $index + 1 ?></td><td><?= $day["weather"] ?> - <i><?= $day["weatherDescription"] ?></i></td><td><?= $day["temp"] ?> grader</td></tr>
        <?php } ?>
    </table>
<?php } ?>

<a href="../weather/form">Hitta väder för en annan söksträng.</a>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    const lat = <?= $lat ?>;
    const lon = <?= $lon ?>;
    const map = L.map('map').setView([lat, lon], 10);
    const marker = L.marker([lat, lon]).addTo(map);
    marker.bindPopup('<?= $query ?>').openPopup();

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map).pin([lat, lon]);
</script>
