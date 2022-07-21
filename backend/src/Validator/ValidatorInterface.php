<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\ValidationException;
use Symfony\Component\Validator\Constraint;

interface ValidatorInterface
{
    /**
     * @param mixed[] $data
     * @throws ValidationException
     */
    public function validate(array $data): void;

    /**
     * @return Constraint[]
     */
    public function getConstraints(): array;
}
