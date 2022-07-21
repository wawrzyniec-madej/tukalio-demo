<?php

declare(strict_types=1);

namespace App\Dto\Exception;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationApiExceptionDto implements ValidationApiExceptionDtoInterface
{
    /** @var array<string, array<int, string|null>> */
    private array $validationErrors = [];

    public function __construct(
        private string $type,
        private string $title,
        private string $detail,
        ConstraintViolationListInterface $constraintViolationList
    ) {
        /** @var ConstraintViolationInterface $constraintViolation */
        foreach ($constraintViolationList as $constraintViolation) {
            $this->validationErrors[$constraintViolation->getPropertyPath()][] = $constraintViolation->getCode();
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'detail' => $this->detail,
            'validationErrors' => $this->validationErrors
        ];
    }
}
