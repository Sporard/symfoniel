<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Simplex\Framework;
use Symfony\Component\EventDispatcher\EventDispatcher;
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

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new Simplex\ContentLengthListener());
$dispatcher->addSubscriber(new Simplex\GoogleListener());

$framework = new Framework($matcher, $controllerResolver, $argumentsResolver, $dispatcher);
$response = $framework->handle($request);
$response->send();