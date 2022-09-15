<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();



$routes->add(
    'leap_year',
    new Route('/is_leap_year/{year}', [
        'name' => 'world',
        '_controller' => 'LeapController::index',
    ])
);
$routes->add('bye', new Route('/bye'));


return $routes;
