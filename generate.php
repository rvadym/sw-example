<?php

require_once __DIR__ . '/vendor/autoload.php';

use Sw\SwConfig;
use Sw\Sw;
use Sw\Util\EndpointFinder\EndpointFinders;
use Sw\Util\EndpointFinder\ControllerMethodEndpointFinder;
use Doctrine\Common\Annotations\AnnotationRegistry;

AnnotationRegistry::registerLoader('class_exists');

$config = new SwConfig(
    ['Api\\Adapter\\Controller'],
    __DIR__ . '/vendor/autoload.php',
    'Api\\Application\\ViewModel\\ValidationErrorViewModel',
    new EndpointFinders(new ControllerMethodEndpointFinder()),
    'Snapcart API',
    'v1.2.3',
    'Proprietary license',
    'http://api.snapcart.global',
    '/v1',
    ['http', 'https'],
    ['application/json'],
    ['application/json']
);


$sw = new Sw($config);
$swagger = $sw->getSwagger();

$json = json_encode($swagger, JSON_PRETTY_PRINT);

echo $json . "\n\n";

file_put_contents('swagger.json', $json);
