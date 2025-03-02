<?php

namespace App\Exception;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpRequestValidationException) {
            $response = new JsonResponse([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => $exception->getViolations(),
            ], 400);
            $event->setResponse($response);
            return;
        }

        if ($exception instanceof HttpException) {
            $response = new JsonResponse([
                'success' => false,
                'message' => $exception->getMessage(),
            ], $exception->getStatusCode());
            $event->setResponse($response);
            return;
        }

        $response = new JsonResponse([
            'success' => false,
            'message' => 'Произошла внутренняя ошибка сервера.',
        ], 500);
        $event->setResponse($response);
    }
}
