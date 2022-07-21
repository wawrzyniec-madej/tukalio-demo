<?php

declare(strict_types=1);

namespace App\Tests\Unit\EventListener;

use App\Dto\Exception\ApiExceptionDtoInterface;
use App\Dto\Exception\ValidationApiExceptionDtoInterface;
use App\EventListener\ApiExceptionListener;
use App\Exception\Api\NotFoundApiException;
use App\Exception\Api\ValidationApiException;
use App\Exception\Api\ValidationApiExceptionInterface;
use App\Exception\ValidationException;
use App\Factory\Dto\Exception\ApiExceptionDtoFactoryInterface;
use App\Factory\Dto\Exception\ValidationApiExceptionDtoFactoryInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ApiExceptionListenerTest extends TestCase
{
    private ValidationApiExceptionDtoFactoryInterface $validationApiExceptionDtoFactory;
    private ApiExceptionDtoFactoryInterface $apiExceptionDtoFactory;
    private EventDispatcher $eventDispatcher;
    private ApiExceptionListener $apiExceptionListener;

    public function setUp(): void
    {
        $this->validationApiExceptionDtoFactory = $this->createMock(ValidationApiExceptionDtoFactoryInterface::class);
        $this->apiExceptionDtoFactory = $this->createMock(ApiExceptionDtoFactoryInterface::class);

        $this->eventDispatcher = new EventDispatcher();
        $this->apiExceptionListener = new ApiExceptionListener(
            $this->apiExceptionDtoFactory,
            $this->validationApiExceptionDtoFactory
        );
    }

    /** @throws Exception */
    public function test_should_omit_exceptions_other_than_http_and_api(): void
    {
        $this->eventDispatcher->addListener('onKernelException', [$this->apiExceptionListener, 'onKernelException']);

        $httpKernel = $this->createMock(HttpKernelInterface::class);
        $request = $this->createMock(Request::class);

        $logicException = new \LogicException('exception we dont want to handle');

        $exceptionEvent = new ExceptionEvent(
            $httpKernel,
            $request,
            HttpKernelInterface::MAIN_REQUEST,
            $logicException
        );

        $this->eventDispatcher->dispatch($exceptionEvent, 'onKernelException');

        self::assertNotInstanceOf(
            JsonResponse::class,
            $exceptionEvent->getResponse()
        );
    }

    /** @throws Exception */
    public function test_should_process_http_exception(): void
    {
        $this->eventDispatcher->addListener('onKernelException', [$this->apiExceptionListener, 'onKernelException']);

        $httpKernel = $this->createMock(HttpKernelInterface::class);
        $request = $this->createMock(Request::class);

        $notFoundHttpException = new NotFoundHttpException('not found');

        $exceptionEvent = new ExceptionEvent(
            $httpKernel,
            $request,
            HttpKernelInterface::MAIN_REQUEST,
            $notFoundHttpException
        );

        $apiExceptionDto = $this->createMock(ApiExceptionDtoInterface::class);

        $this->apiExceptionDtoFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($apiExceptionDto);

        $this->eventDispatcher->dispatch($exceptionEvent, 'onKernelException');

        self::assertInstanceOf(
            JsonResponse::class,
            $exceptionEvent->getResponse()
        );
    }

    /** @throws Exception */
    public function test_should_process_api_exception(): void
    {
        $this->eventDispatcher->addListener('onKernelException', [$this->apiExceptionListener, 'onKernelException']);

        $httpKernel = $this->createMock(HttpKernelInterface::class);
        $request = $this->createMock(Request::class);

        $notFoundApiException = new NotFoundApiException();

        $exceptionEvent = new ExceptionEvent(
            $httpKernel,
            $request,
            HttpKernelInterface::MAIN_REQUEST,
            $notFoundApiException
        );

        $apiExceptionDto = $this->createMock(ApiExceptionDtoInterface::class);

        $this->apiExceptionDtoFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($apiExceptionDto);

        $this->eventDispatcher->dispatch($exceptionEvent, 'onKernelException');

        self::assertInstanceOf(
            JsonResponse::class,
            $exceptionEvent->getResponse()
        );
    }

    /** @throws Exception */
    public function test_should_process_validation_api_exception(): void
    {
        $this->eventDispatcher->addListener('onKernelException', [$this->apiExceptionListener, 'onKernelException']);

        $httpKernel = $this->createMock(HttpKernelInterface::class);
        $request = $this->createMock(Request::class);

        $constraintViolationList = $this->createMock(ConstraintViolationListInterface::class);
        $validationApiException = new ValidationApiException(
            new ValidationException($constraintViolationList)
        );

        $exceptionEvent = new ExceptionEvent(
            $httpKernel,
            $request,
            HttpKernelInterface::MAIN_REQUEST,
            $validationApiException
        );

        $validationApiExceptionDto = $this->createMock(ValidationApiExceptionDtoInterface::class);

        $this->validationApiExceptionDtoFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($validationApiExceptionDto);

        $this->eventDispatcher->dispatch($exceptionEvent, 'onKernelException');

        self::assertInstanceOf(
            JsonResponse::class,
            $exceptionEvent->getResponse()
        );
    }
}
