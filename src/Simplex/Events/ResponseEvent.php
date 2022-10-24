<?php
namespace Simplex\Events;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class ResponseEvent extends Event
{
    public function __construct(private Response $response, private Request $request)
    {
    }
   public function getResponse()
   {
       return $this->response;
   }
   public function getRequest()
   {
       return $this->request;
   }
}
