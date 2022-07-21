<?php

declare(strict_types=1);

namespace App\Factory\Dto\Exception;

use App\Dto\Exception\ApiExceptionDto;
use App\Dto\Exception\ApiExceptionDtoInterface;

final class ApiExceptionDtoFactory implements ApiExceptionDtoFactoryInterface
{
    public function create(string $type, string $title, string $detail): ApiExceptionDtoInterface
    {
        return new ApiExceptionDto($type, $title, $detail);
    }
}
