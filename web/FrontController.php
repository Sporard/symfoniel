<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

function render_template(Request $request)
{
    extract($matcher->match($request->getPathInfo(), EXTR_SKIP));
    ob_start();
    include sprintf(__DIR__ . '/../src/pages/%s.php', $_route);
    return new Response(ob_get_clean());
}



$request = Request::createFromGlobals();
$response =  new Response();


$routes = include __DIR__ . '/../src/app.php';

$context = new RequestContext();
$context->fromRequest($request);

$matcher = new UrlMatcher($routes, $context);

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));
    $response = call_user_func($request->attributes->get('_controller'), $request);
} catch (ResourceNotFoundException $e) {
    $response = new Response('Not Found', 404);
} catch (Exception $e) {
    $response = new Response($e->getMessage(), 500);
}


$response->send();
