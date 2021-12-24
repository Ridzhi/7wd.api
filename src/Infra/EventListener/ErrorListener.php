<?php

namespace App\Infra\EventListener;

use App\Error\Error;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelInterface;

class ErrorListener
{
    public function __construct(
        private LoggerInterface $logger,
        private KernelInterface $kernel,
    ){}

    public function onKernelException(ExceptionEvent $event)
    {
        $error = $event->getThrowable();
        $message = '';
        $status = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($error instanceof Error) {
            $message = $error->getMessage();
            $status = Response::HTTP_BAD_REQUEST;
        } elseif ($error instanceof HttpException) {
            // HttpException is safe to public error message
            $message = $error->getMessage();
            $status = $error->getStatusCode();
        } else {
            if (in_array($this->kernel->getEnvironment(), ['dev', 'test'])) {
                $message = $error->getMessage();
            }

            $this->logger->error($error->getMessage());
        }

        $event->setResponse(new JsonResponse(
            [
                'err_message' => $message,
            ],
            $status
        ));
    }
}
