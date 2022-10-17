<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Simplex\Framework;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\ErrorListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$controllerResolver = new ControllerResolver();
$argumentsResolver = new ArgumentResolver();


$routes = include __DIR__ . '/../src/app.php';
$request = Request::createFromGlobals();
$requestStack = new RequestStack();

$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context);

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new Simplex\ContentLengthListener());
$dispatcher->addSubscriber(new Simplex\GoogleListener());
$dispatcher->addSubscriber(new RouterListener($matcher, $requestStack));
$dispatcher->addSubscriber(new ErrorListener(
    'Calendar\Controller\ErrorController::exception'
));
$dispatcher->addSubscriber(new Simplex\StringResponseListener());


$framework = new Framework($dispatcher, $controllerResolver, $requestStack, $argumentsResolver);
$framework = new HttpCache(
    $framework,
    new Store(__DIR__ . '/../cache')
);
$response = $framework->handle($request);
$response->send();