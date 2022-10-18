<?php

namespace Simplex;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\ErrorListener;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class Framework extends HttpKernel
{
    /**
     * @param $routes
     */
    public function __construct($routes)
    {
        $controllerResolver = new ControllerResolver();
        $argumentsResolver = new ArgumentResolver();


        $requestStack = new RequestStack();

        $context = new RequestContext();
        $matcher = new UrlMatcher($routes, $context);

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new ContentLengthListener());
        $dispatcher->addSubscriber(new GoogleListener());
        $dispatcher->addSubscriber(new RouterListener($matcher, $requestStack));
        $dispatcher->addSubscriber(new ErrorListener(
            'Calendar\Controller\ErrorController::exception'
        ));
        $dispatcher->addSubscriber(new ResponseListener('UTF-8'));
        $dispatcher->addSubscriber(new StringResponseListener());

        parent::__construct($dispatcher, $controllerResolver, $requestStack, $argumentsResolver);

    }

}
