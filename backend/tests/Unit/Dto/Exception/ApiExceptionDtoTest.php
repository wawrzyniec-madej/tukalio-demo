<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto\Exception;

use App\Dto\Exception\ApiExceptionDto;
use App\Tests\Unit\Dto\AbstractDtoTestCase;

final class ApiExceptionDtoTest extends AbstractDtoTestCase
{
    public function test_serialization_success(): void
    {
        $apiExceptionDto = new ApiExceptionDto(
            'type',
            'title',
            'detail'
        );

        self::assertEquals(
            $this->getExpectedSerializationResult(),
            $apiExceptionDto->jsonSerialize()
        );
    }

    public function getExpectedSerializationResult(): array
    {
        return [
            'type' => 'type',
            'title' => 'title',
            'detail' => 'detail'
        ];
    }
}
