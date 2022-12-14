<?php

namespace Simplex\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class ResponseListener implements EventSubscriberInterface
{
    public function onView(ViewEvent $event)
    {
        $response = $event->getControllerResult();

        if (is_string($response)) {
            $event->setResponse(new Response($response));
        } else {
            $data = [
                "data" => $response
            ];
            $jsonResponse = new Response(json_encode($data));
            $jsonResponse->headers->set('Content-type', 'application/json');
            $event->setResponse($endResponse);
        }

    }

    public static function getSubscribedEvents()
    {
        return ['kernel.view' => 'onView'];
    }
}
