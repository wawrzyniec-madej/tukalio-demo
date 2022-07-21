<?php

declare(strict_types=1);

namespace App\Exception\Api;

use Exception;

abstract class AbstractApiException extends Exception
{
    public const TYPE_NOT_FOUND = 'NotFound';
    public const TYPE_BAD_REQUEST = 'BadRequest';
    public const TYPE_DEFAULT = 'Default';
    public const TYPE_VALIDATION_ERROR = 'ValidationError';

    public function __construct(
        private string $type,
        private string $title,
        private string $detail,
        private int $responseStatus
    ) {
        parent::__construct();
    }

    public function getResponseStatus(): int
    {
        return $this->responseStatus;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDetail(): string
    {
        return $this->detail;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
