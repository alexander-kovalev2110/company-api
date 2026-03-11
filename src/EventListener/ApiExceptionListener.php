<?php

// namespace App\EventListener;

// use Symfony\Component\HttpKernel\Event\ExceptionEvent;
// use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

// class ApiExceptionListener
// {
//     public function onKernelException(ExceptionEvent $event): void
//     {
//         $e = $event->getThrowable();

//         // If the exception implements HttpExceptionInterface, we take the HTTP code from it
//         if ($e instanceof HttpExceptionInterface) {
//             $statusCode = $e->getStatusCode();
//         } else {
//             // Otherwise, we use the exception code if it is correct for HTTP, otherwise 400
//             $statusCode = ($e->getCode() >= 100 && $e->getCode() < 600) ? $e->getCode() : 400;
//         }

//         $response = new JsonResponse([
//             'error' => $e->getMessage(),
//             'code'  => $statusCode,
//         ], $statusCode);

//         $event->setResponse($response);
//     }
// }

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

        // 1️⃣ Обработка нарушения уникальности (DB constraint)
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

        // 2️⃣ Если исключение содержит HTTP код (например NotFoundHttpException)
        if ($e instanceof HttpExceptionInterface) {
            $statusCode = $e->getStatusCode();
        } else {
            // fallback: используем код исключения если он похож на HTTP
            $statusCode = ($e->getCode() >= 100 && $e->getCode() < 600)
                ? $e->getCode()
                : 400;
        }

        // 3️⃣ Стандартная JSON ошибка API
        $response = new JsonResponse([
            'error' => [
                'code' => $statusCode,
                'message' => $e->getMessage()
            ]
        ], $statusCode);

        $event->setResponse($response);
    }
}