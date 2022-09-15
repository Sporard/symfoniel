<?php

namespace Simplex;

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Exception;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\Request;

class Framework
{
    public function __construct(private UrlMatcher $urlMatcher, private ControllerResolver $controllerResolver, private ArgumentResolver $argumentResolver)
    {
    }
/**
 *
 */
    public function handle(Request $request)
    {
        $matcher = $this->urlMatcher->getContext()->fromRequest($request);
        try {
            $request->attributes->add($this->urlMatcher->match($request->getPathInfo()));
            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentsResolver->getArguments($request, $controller);
            return call_user_func($controller, $arguments);
        } catch (ResourceNotFoundException $e) {
            $response = new Response('Not Found', 404);
        } catch (Exception $e) {
            $response = new Response($e->getMessage(), 500);
        }
    }
}
