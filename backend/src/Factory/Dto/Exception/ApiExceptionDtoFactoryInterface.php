<?php

declare(strict_types=1);

namespace App\Factory\Dto\Exception;

use App\Dto\Exception\ApiExceptionDtoInterface;

interface ApiExceptionDtoFactoryInterface
{
    public function create(string $type, string $title, string $detail): ApiExceptionDtoInterface;
}
