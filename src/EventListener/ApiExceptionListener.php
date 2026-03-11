<?php

namespace App\EventListener;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ApiExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        // Handling uniqueness violations (DB constraint)
        if ($e instanceof UniqueConstraintViolationException) {

            $response = new JsonResponse([
                'error' => [
                    'code' => 'UNIQUE_CONSTRAINT_VIOLATION',
                    'message' => 'Entity with the same unique field already exists'
                ]
            ], 409); // HTTP 409 Conflict

            $event->setResponse($response);
            return;
        }

        // If the exception contains an HTTP code (e.g. NotFoundHttpException)
        if ($e instanceof HttpExceptionInterface) {
            $statusCode = $e->getStatusCode();
        } else {
            // fallback: используем код исключения если он похож на HTTP
            $statusCode = ($e->getCode() >= 100 && $e->getCode() < 600)
                ? $e->getCode()
                : 400;
        }

        // Standard JSON API error
        $response = new JsonResponse([
            'error' => [
                'code' => $statusCode,
                'message' => $e->getMessage()
            ]
        ], $statusCode);

        $event->setResponse($response);
    }
}