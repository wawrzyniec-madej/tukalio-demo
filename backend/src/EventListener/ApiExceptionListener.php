<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\Api\AbstractApiException;
use App\Exception\Api\DefaultApiException;
use App\Exception\Api\NotFoundApiException;
use App\Exception\Api\ValidationApiException;
use App\Factory\Dto\Exception\ApiExceptionDtoFactoryInterface;
use App\Factory\Dto\Exception\ValidationApiExceptionDtoFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ApiExceptionListener
{
    public function __construct(
        private ApiExceptionDtoFactoryInterface $apiExceptionDtoFactory,
        private ValidationApiExceptionDtoFactoryInterface $validationApiExceptionDtoFactory
    ) {
    }

    public function onKernelException(ExceptionEvent $exceptionEvent): void
    {
        $exception = $exceptionEvent->getThrowable();

        if (
            !$exception instanceof HttpExceptionInterface &&
            !$exception instanceof AbstractApiException
        ) {
            return;
        }

        if ($exception instanceof NotFoundHttpException) {
            $exception = new NotFoundApiException();
        } elseif ($exception instanceof HttpExceptionInterface) {
            $exception = new DefaultApiException(
                detail: $exception->getMessage(),
                responseStatus: $exception->getStatusCode()
            );
        }

        if ($exception instanceof ValidationApiException) {
            $responseBody = $this->validationApiExceptionDtoFactory->create(
                $exception->getType(),
                $exception->getTitle(),
                $exception->getDetail(),
                $exception->getConstraintViolationList()
            );
        } else {
            $responseBody = $this->apiExceptionDtoFactory->create(
                $exception->getType(),
                $exception->getTitle(),
                $exception->getDetail()
            );
        }

        $response = new JsonResponse(
            $responseBody,
            $exception->getResponseStatus()
        );

        $exceptionEvent->setResponse($response);

        $exceptionEvent->setThrowable(
            $exception
        );
    }
}
