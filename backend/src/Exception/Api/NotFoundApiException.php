<?php

declare(strict_types=1);

namespace App\Exception\Api;

use Symfony\Component\HttpFoundation\Response;

final class NotFoundApiException extends AbstractApiException
{
    public function __construct(
        string $title = 'Not found',
        string $detail = 'Result was not found'
    ) {
        parent::__construct(
            AbstractApiException::TYPE_NOT_FOUND,
            $title,
            $detail,
            Response::HTTP_NOT_FOUND
        );
    }
}
