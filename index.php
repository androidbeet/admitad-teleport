<?php

include 'vendor/autoload.php';

use Classes\TeleportClass;

$teleport = (new TeleportClass())
    ->setUrl('https://ad.admitad.com/tpt/1e8d114494b7e165239416525dc3e8/')
    ->setCountryCode('ru');

echo $teleport->open();