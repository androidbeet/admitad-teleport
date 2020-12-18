<?php

error_reporting(-1);

ini_set('display_errors', 'On');

include 'vendor/autoload.php';

use Classes\TeleportClass;

$teleport = (new TeleportClass())
    ->setUrl('https://ad.admitad.com/tpt/1e8d114494b7e165239416525dc3e8/')
    ->setCountryCode('en');

echo $teleport->getDestinationUrl();