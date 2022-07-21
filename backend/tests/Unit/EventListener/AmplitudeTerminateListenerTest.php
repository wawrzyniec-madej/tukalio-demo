<?php

declare(strict_types=1);

namespace App\Tests\Unit\EventListener;

use App\Client\Amplitude\AmplitudeClientInterface;
use App\Collection\Event\AmplitudeEventCollection;
use App\Container\AmplitudeEventContainerInterface;
use App\Event\Amplitude\AmplitudeEventInterface;
use App\EventListener\AmplitudeTerminateListener;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class AmplitudeTerminateListenerTest extends TestCase
{
    private AmplitudeEventContainerInterface $amplitudeEventContainer;
    private AmplitudeClientInterface $amplitudeClient;
    private EventDispatcher $eventDispatcher;

    public function setUp(): void
    {
        $this->amplitudeEventContainer = $this->createMock(AmplitudeEventContainerInterface::class);
        $this->amplitudeClient = $this->createMock(AmplitudeClientInterface::class);

        $this->eventDispatcher = new EventDispatcher();
    }

    /** @throws Exception */
    public function test_terminate_sends_amplitude_events(): void
    {
        $firstEvent = $this->createMock(AmplitudeEventInterface::class);
        $secondEvent = $this->createMock(AmplitudeEventInterface::class);

        $this->amplitudeEventContainer
            ->method('getAmplitudeEventCollection')
            ->willReturn(new AmplitudeEventCollection([
                $firstEvent,
                $secondEvent
            ]));

        $amplitudeTerminateListener = new AmplitudeTerminateListener(
            $this->amplitudeEventContainer,
            $this->amplitudeClient
        );

        $this->eventDispatcher->addListener('onKernelTerminate', [$amplitudeTerminateListener, 'onKernelTerminate']);

        $httpKernel = $this->createMock(HttpKernelInterface::class);

        $request = new Request(
            content: json_encode([
                'test' => 'test'
            ], JSON_THROW_ON_ERROR)
        );

        $terminateEvent = new TerminateEvent(
            $httpKernel,
            $request,
            new Response()
        );

        $this->amplitudeClient
            ->expects($this->exactly(2))
            ->method('sendEvent')
            ->withConsecutive(
                [$firstEvent],
                [$secondEvent]
            );

        $this->eventDispatcher->dispatch($terminateEvent, 'onKernelTerminate');
    }
}
