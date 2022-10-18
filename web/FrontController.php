<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Simplex\Framework;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;


$routes = include __DIR__ . '/../src/app.php';
$request = Request::createFromGlobals();


$framework = new Framework($routes);
$framework->handle($request)->send();