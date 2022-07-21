<?php

declare(strict_types=1);

namespace App\Factory\Dto\Exception;

use App\Dto\Exception\ValidationApiExceptionDto;
use App\Dto\Exception\ValidationApiExceptionDtoInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationApiExceptionDtoFactory implements ValidationApiExceptionDtoFactoryInterface
{
    public function create(
        string $type,
        string $title,
        string $detail,
        ConstraintViolationListInterface $constraintViolationList
    ): ValidationApiExceptionDtoInterface {
        return new ValidationApiExceptionDto($type, $title, $detail, $constraintViolationList);
    }
}
