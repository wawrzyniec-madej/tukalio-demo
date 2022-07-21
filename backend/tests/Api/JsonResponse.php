<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Helper\JsonHelper;
use Exception;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class JsonResponse
{
    private array $content;
    private int $statusCode;

    /** @throws Exception|TransportExceptionInterface */
    public function __construct(
        private ResponseInterface $response
    ) {
        $this->content = $this->decodeJsonContent($this->response->getContent());
        $this->statusCode = $this->response->getStatusCode();
    }

    /** @throws Exception */
    protected function decodeJsonContent(string $content): array
    {
        return JsonHelper::decodeJson($content);
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
