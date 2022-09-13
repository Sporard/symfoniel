<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();


function is_leap_year(int $year = null)
{
    if (is_null($year)) {
        $year = date('Y');
    }

    return $year % 400 === 0 || ($year % 4 === 0 && !($year % 100 === 0));
}

$routes->add(
    'leap_year',
    new Route('/is_leap_year/{year}', [
        'name' => 'world',
        '_controller' => function (Request $request) {
            if (is_leap_year($request->attributes->get('year'))){
                return new Response('Yes it is');
            }

            return new Response('No it\'s not', 400);
        }
    ])
);
$routes->add('bye', new Route('/bye'));


return $routes;
