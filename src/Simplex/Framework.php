<?php

namespace Simplex;

use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

class Framework extends HttpKernel
{
    /**
     * @param EventDispatcher $eventDispatcher
     * @param ControllerResolverInterface $controllerResolver
     * @param $requestStack
     * @param ArgumentResolverInterface $argumentResolver
     */
    public function __construct(private EventDispatcher             $eventDispatcher,
                                private ControllerResolverInterface $controllerResolver,
                                protected                           $requestStack,
                                private ArgumentResolverInterface   $argumentResolver,
    )
    {
        parent::__construct($this->eventDispatcher, $this->controllerResolver, $this->requestStack, $this->argumentResolver);
    }

}
