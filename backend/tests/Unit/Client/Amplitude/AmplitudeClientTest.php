<?php
declare(strict_types=1);

namespace App\Tests\Unit\Client\Amplitude;

use App\Client\Amplitude\AmplitudeClient;
use App\Client\Amplitude\AmplitudeClientInterface;
use App\Event\Amplitude\AmplitudeEventInterface;
use App\Event\Amplitude\ShoppingListCreatedAmplitudeEventInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\Exception\TimeoutException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class AmplitudeClientTest extends TestCase
{
    private HttpClientInterface $httpClient;
    private AmplitudeClientInterface $amplitudeClient;
    private LoggerInterface $logger;

    public function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpClientInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->amplitudeClient = new AmplitudeClient(
            'apiKey',
            $this->httpClient,
            $this->logger
        );
    }

    /** @throws Exception */
    public function test_sendEvent_success(): void
    {
        $amplitudeEvent = $this->createMock(ShoppingListCreatedAmplitudeEventInterface::class);

        $this->httpClient
            ->expects($this->once())
            ->method('request');

        $this->amplitudeClient->sendEvent(
            $amplitudeEvent
        );
    }

    /** @throws Exception */
    public function test_sendEvent_not_sends_on_blank_key(): void
    {
        $amplitudeEvent = $this->createMock(AmplitudeEventInterface::class);

        $this->amplitudeClient = new AmplitudeClient(
            '',
            $this->httpClient,
            $this->logger
        );

        $this->httpClient
            ->expects($this->never())
            ->method('request');

        $this->amplitudeClient->sendEvent(
            $amplitudeEvent
        );
    }

    /** @throws Exception */
    public function test_sendEvent_connection_exception(): void
    {
        $amplitudeEvent = $this->createMock(ShoppingListCreatedAmplitudeEventInterface::class);

        $exception = new TimeoutException();

        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->willThrowException($exception);

        $this->logger
            ->expects($this->once())
            ->method('error')
            ->with($exception->getMessage());

        $this->amplitudeClient->sendEvent(
            $amplitudeEvent
        );
    }
}
