<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Simplex\Framework;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$controllerResolver = new ControllerResolver();
$argumentsResolver = new ArgumentResolver();



$routes = include __DIR__ . '/../src/app.php';
$request = Request::createFromGlobals();

$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context); 
$framework = new Framework($matcher, $controllerResolver, $argumentsResolver);
$response = $framework->handle($request);
$response->send();