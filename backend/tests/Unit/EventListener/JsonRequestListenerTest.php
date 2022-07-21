<?php

declare(strict_types=1);

namespace App\Tests\Unit\EventListener;

use App\EventListener\JsonRequestListener;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class JsonRequestListenerTest extends TestCase
{
    private EventDispatcher $eventDispatcher;

    public function setUp(): void
    {
        $this->eventDispatcher = new EventDispatcher();
    }

    /** @throws Exception */
    public function test_json_request_should_have_valid_parameters(): void
    {
        $jsonRequestListener = new JsonRequestListener();

        $this->eventDispatcher->addListener('onKernelRequest', [$jsonRequestListener, 'onKernelRequest']);

        $httpKernel = $this->createMock(HttpKernelInterface::class);

        $request = new Request(
            content: json_encode([
                'test' => 'test'
            ], JSON_THROW_ON_ERROR)
        );
        $request->headers->add([
            'Content-Type' => 'application/json'
        ]);

        $requestEvent = new RequestEvent(
            $httpKernel,
            $request,
            HttpKernelInterface::MAIN_REQUEST
        );

        $this->eventDispatcher->dispatch($requestEvent, 'onKernelRequest');

        $resultRequest = $requestEvent->getRequest();

        self::assertEquals(
            'test',
            $resultRequest->request->get('test')
        );
    }
}
