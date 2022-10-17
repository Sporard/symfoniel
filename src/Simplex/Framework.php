<?php

namespace Simplex;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Exception;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class Framework implements HttpKernelInterface
{
    public function __construct(
        private UrlMatcherInterface         $urlMatcher,
        private ControllerResolverInterface $controllerResolver,
        private ArgumentResolverInterface   $argumentResolver,
        private EventDispatcher             $eventDispatcher
    )
    {
    }

    /**
     *
     */
    public function handle(Request $request,
                           int     $type = HttpKernelInterface::MAIN_REQUEST,
                           bool    $catch = true): Response
    {
        $this->urlMatcher->getContext()->fromRequest($request);
        try {
            $request->attributes->add($this->urlMatcher->match($request->getPathInfo()));
            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);
            $response = call_user_func($controller, ...$arguments);
        } catch (ResourceNotFoundException $e) {
            $response = new Response('Not Found', 404);
        } catch (Exception $e) {
            $response = new Response($e->getMessage(), 500);
        }
        $this->eventDispatcher->dispatch(new ResponseEvent($response, $request), 'response');
        return $response;
    }
}
