<?php

require_once __DIR__ . '/../vendor/autoload.php';

use LDAP\Result;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$controllerResolver = new ControllerResolver();
$argumentsResolver = new ArgumentResolver();
try {
    $controller = $controllerResolver->getController($request);
    $arguments = $argumentsResolver->getArguments($request, $controller);
    $response = call_user_func($controller, $arguments);

} catch (ResourceNotFoundException $e) {
    $response = new Response('Not Found', 404);
} catch (Exception $e) {
    $response = new Response($e->getMessage(), 500);
}
