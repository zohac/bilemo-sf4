<?php

// src/EventListener/ExceptionListener.php

namespace App\EventListener;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct()
    {
        // Create new normalizer
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        // Create new serializer
        $this->serializer = new Serializer([$normalizer], [new JsonEncoder()]);
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();

        //var_dump($exception); die;
        $messages = (method_exists($exception, 'getMessages')) ? $exception->getMessages() : $exception->getMessage();

        $message[] = [
            'code' => $exception->getStatusCode(),
            'messages' => $messages,
        ];

        // Customize the response object to display the exception details
        $response = new JsonResponse();
        $response->setContent($this->serializer->serialize(['errors' => $message], 'json'));

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        $satusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($exception instanceof HttpExceptionInterface) {
            $satusCode = $exception->getStatusCode();
        }
        $response->setStatusCode($satusCode);
        $response->headers->set('Content-Type', 'application/json');

        // sends the modified response object to the event
        $event->setResponse($response);
    }
}
