<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto\Exception;

use App\Dto\Exception\ValidationApiExceptionDto;
use App\Helper\JsonHelper;
use App\Tests\Unit\Dto\AbstractDtoTestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationApiExceptionDtoTest extends AbstractDtoTestCase
{
    public function test_serialization_success(): void
    {
        $constraintViolationList = $this->createMock(ConstraintViolationListInterface::class);

        $validationApiExceptionDto = new ValidationApiExceptionDto(
            'type',
            'title',
            'detail',
            $constraintViolationList
        );

        self::assertEquals(
            $this->getExpectedSerializationResult(),
            JsonHelper::serializeFully($validationApiExceptionDto)
        );
    }

    public function getExpectedSerializationResult(): array
    {
        return [
            'type' => 'type',
            'title' => 'title',
            'detail' => 'detail',
            'validationErrors' => []
        ];
    }
}
