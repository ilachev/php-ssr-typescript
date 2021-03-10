<?php

declare(strict_types=1);

namespace App\Controller\Api;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UsernameNotFoundExceptionFormatter implements EventSubscriberInterface
{
    #[ArrayShape([KernelEvents::EXCEPTION => 'string'])]
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof UsernameNotFoundException) {
            return;
        }

        $event->setResponse(new JsonResponse([
            'error' => $exception->getMessage(),
        ], 400));
    }
}
