<?php

declare(strict_types=1);

namespace App\Exception\Api;

use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationApiException extends AbstractApiException
{
    private ConstraintViolationListInterface $constraintViolationList;

    public function __construct(
        ValidationException $validationException,
        string $title = 'Validation problem',
        string $detail = 'Validation was not successful'
    ) {
        $this->constraintViolationList = $validationException->getConstraintViolationList();

        parent::__construct(
            AbstractApiException::TYPE_VALIDATION_ERROR,
            $title,
            $detail,
            Response::HTTP_BAD_REQUEST
        );
    }

    public function getConstraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}
