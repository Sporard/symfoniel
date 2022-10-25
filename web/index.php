<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Simplex\Listener\ResponseListener;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\Request;

$container = include __DIR__ . '/../config/services.php';
$request = Request::createFromGlobals();
$container->register('listener.string_response', ResponseListener::class);
$container->setParameter('templatesDir', __DIR__ . '/../src/templates');
$container->getDefinition('dispatcher')
    ->addMethodCall('addSubscriber', [new Reference('listener.string_response')]);
$container->getDefinition('matcher')->replaceArgument(0, include __DIR__ . '/../config/routes.php');
$container->get('framework')->handle($request)->send();
