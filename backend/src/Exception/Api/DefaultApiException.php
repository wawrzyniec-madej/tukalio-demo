<?php

declare(strict_types=1);

namespace App\Exception\Api;

use Symfony\Component\HttpFoundation\Response;

final class DefaultApiException extends AbstractApiException
{
    public function __construct(
        string $title = 'Exception',
        string $detail = "I've got a bad feeling about this",
        int $responseStatus = Response::HTTP_INTERNAL_SERVER_ERROR
    ) {
        parent::__construct(
            AbstractApiException::TYPE_DEFAULT,
            $title,
            $detail,
            $responseStatus
        );
    }
}
