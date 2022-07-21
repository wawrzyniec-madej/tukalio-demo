<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\ValidationException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractValidator
{
    public function __construct(
        private ValidatorInterface $validator
    ) {
    }

    /**
     * @param mixed[] $data
     * @param Constraint[] $constraints
     * @throws ValidationException
     */
    protected function validateWithConstraints(array $data, array $constraints): void
    {
        $errors = $this->validator->validate($data, $constraints);

        if ($errors->count() > 0) {
            throw new ValidationException($errors);
        }
    }
}
