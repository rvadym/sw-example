<?php

require_once __DIR__ . '/vendor/autoload.php';

use Sw\SwConfig;
use Sw\Sw;

$config = new SwConfig(
    [
        'Api\\Adapter\\Controller'
    ],
    __DIR__ . '/vendor/autoload.php'
);


$sw = new Sw($config);
$sw->run();
