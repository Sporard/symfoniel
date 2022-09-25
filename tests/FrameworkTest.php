<?php

use PHPUnit\Framework\TestCase;
use Simplex\Framework;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class FrameworkTest extends TestCase{



    public function testNotFoundHandling() {
        $framework = $this->getFrameworkForException(new ResourceNotFoundException());
        $response = $framework->handle(new Request());
        $this->assertEquals(404, $response->getStatusCode());

    }

    public function getFrameworkForException($exception) {
        $matcher = $this->createMock(UrlMatcher::class);
        $matcher->expects($this->once())
        ->method('match')
        ->will($this->throwException($exception));

        $matcher->expects($this->once())
        ->method('getContext')
        ->will($this->returnValue($this->createMock(RequestContext::class)));

        $controllerResolver = $this->createMock(ControllerResolverInterface::class);
        $argumentResolver = $this->createMock(ArgumentResolverInterface::class);

        return new Framework($matcher, $controllerResolver, $argumentResolver);
    }
}