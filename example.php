<?php

require __DIR__ . '/vendor/autoload.php';

use MallardDuck\Whodis\Whodis;

$whodis = new Whodis();
$response = $whodis->lookup('danpock.me', fullResults: true);
echo $response;
