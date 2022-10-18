<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Simplex\StringResponseListener;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\Request;

$container = include __DIR__ . '/../src/container.php';
$request = Request::createFromGlobals();
$container->register('listener.string_response', StringResponseListener::class);
$container->getDefinition('dispatcher')
    ->addMethodCall('addSubscriber', [new Reference('listener.string_response')]);
$container->setParameter('routes', include __DIR__ . '/../src/app.php');
$container->get('framework')->handle($request)->send();