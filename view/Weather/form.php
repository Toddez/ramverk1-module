<?php

namespace Anax\View;

if (!isset($action)) {
    $action = "";
}

if (!isset($method)) {
    $method = "get";
}

if (!isset($title)) {
    $title = "Väder";
}

if (!isset($query)) {
    $query = "";
}

?><h3><?= $title ?></h3>

<?php
if (isset($text)) {
    ?><p><?= $text ?></p><?php
}
?>

<p>Söksträngen kan vara en ip adress eller t.ex. en stad som London.</p>

<form action="<?= $action ?>" method="<?= $method ?>" class="validator-form">
    <input type="text" name="query" id="query" placeholder="Söksträng, ex. London" value="<?= $query ?>">
    <input type="submit" value="Sök väder">
</form>
