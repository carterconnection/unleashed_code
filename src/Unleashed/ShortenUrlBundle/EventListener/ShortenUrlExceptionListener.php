<?php

namespace Unleashed\ShortenUrlBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Bundle\TwigBundle\TwigEngine;

class ShortenUrlExceptionListener
{
    private $templating;
    private $message;
    
    public function __construct($templating)
    {
        $this->templating = $templating;
    }
    
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

            $this->message = $exception->getMessage();


        $response = new Response(
            $this->templating->render(
                'UnleashedShortenUrlBundle:Error:exception.html.twig'
                , array(
                    'message' => $this->message
                )
            )
        );

        $event->setResponse($response);

    }
}

