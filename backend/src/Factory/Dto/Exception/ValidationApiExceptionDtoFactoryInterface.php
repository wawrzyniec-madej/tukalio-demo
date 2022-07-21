<?php

declare(strict_types=1);

namespace App\Factory\Dto\Exception;

use App\Dto\Exception\ValidationApiExceptionDtoInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface ValidationApiExceptionDtoFactoryInterface
{
    public function create(
        string $type,
        string $title,
        string $detail,
        ConstraintViolationListInterface $constraintViolationList
    ): ValidationApiExceptionDtoInterface;
}
