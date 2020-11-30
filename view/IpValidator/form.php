<?php

namespace Anax\View;

if (!isset($action)) {
    $action = "";
}

if (!isset($method)) {
    $method = "get";
}

if (!isset($title)) {
    $title = "IP Validator";
}

if (!isset($ipAddress)) {
    $ipAddress = "";
}

?><h3><?= $title ?></h3>

<?php
if (isset($text)) {
    ?><p><?= $text ?></p><?php
}
?>

<form action="<?= $action ?>" method="<?= $method ?>" class="validator-form">
    <input type="text" name="ip" id="ip" placeholder="IP Adress" value="<?= $ipAddress ?>">
    <input type="submit" value="Validera">
</form>
