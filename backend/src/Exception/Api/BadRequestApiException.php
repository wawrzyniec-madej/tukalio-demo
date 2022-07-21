<?php

declare(strict_types=1);

namespace App\Exception\Api;

use Symfony\Component\HttpFoundation\Response;

final class BadRequestApiException extends AbstractApiException
{
    public function __construct(string $title = 'Bad request', string $detail = 'Request data is wrong')
    {
        parent::__construct(
            AbstractApiException::TYPE_BAD_REQUEST,
            $title,
            $detail,
            Response::HTTP_BAD_REQUEST
        );
    }
}
