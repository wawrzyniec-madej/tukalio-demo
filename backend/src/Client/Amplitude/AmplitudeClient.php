<?php

declare(strict_types=1);

namespace App\Client\Amplitude;

use App\Event\Amplitude\AmplitudeEventInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class AmplitudeClient implements AmplitudeClientInterface
{
    private const AMPLITUDE_API_ENDPOINT = 'https://api2.amplitude.com/2/httpapi';

    public function __construct(
        private string $amplitudeApiKey,
        private HttpClientInterface $httpClient,
        private LoggerInterface $logger
    ) {}

    public function sendEvent(AmplitudeEventInterface $amplitudeEvent): void
    {
        if ($this->amplitudeApiKey === '') {
            return;
        }
        
        $requestBody = [
            'api_key' => $this->amplitudeApiKey,
            'events' => [
                ...$amplitudeEvent->getBody()
            ]
        ];

        try {
            $this->httpClient->request(
                'POST',
                self::AMPLITUDE_API_ENDPOINT,
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => '*/*'
                    ],
                    'body' => json_encode(
                        $requestBody,
                        JSON_THROW_ON_ERROR
                    )
                ]
            );
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
