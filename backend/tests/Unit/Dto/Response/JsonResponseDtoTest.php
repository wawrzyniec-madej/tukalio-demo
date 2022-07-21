<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto\Response;

use App\Collection\Dto\ShoppingListItemDtoCollection;
use App\Dto\Response\JsonResponseDto;
use App\Dto\ShoppingListItem\ShoppingListItemDtoInterface;
use App\Helper\JsonHelper;
use App\Tests\Unit\Dto\AbstractDtoTestCase;
use Exception;
use JsonSerializable;

final class JsonResponseDtoTest extends AbstractDtoTestCase
{
    /** @throws Exception */
    public function test_serialization_of_jsonSerializable_success(): void
    {
        $jsonSerializable = $this->createMock(JsonSerializable::class);
        $jsonSerializable
            ->method('jsonSerialize')
            ->willReturn([
                'serialized!'
            ]);

        $jsonResponseDto = new JsonResponseDto($jsonSerializable);

        self::assertEquals(
            $this->getExpectedSingleSerializationResult(),
            JsonHelper::serializeFully($jsonResponseDto)
        );
    }

    /** @throws Exception */
    public function test_serialization_of_objectCollection_success(): void
    {
        $shoppingListItemDto = $this->createMock(ShoppingListItemDtoInterface::class);
        $shoppingListItemDto
            ->method('jsonSerialize')
            ->willReturn([
                'serialized!'
            ]);

        $shoppingListItemDtoCollection = new ShoppingListItemDtoCollection([
            $shoppingListItemDto,
            $shoppingListItemDto
        ]);


        $jsonResponseDto = new JsonResponseDto($shoppingListItemDtoCollection);

        self::assertEquals(
            $this->getExpectedMultiSerializationResult(),
            JsonHelper::serializeFully($jsonResponseDto)
        );
    }

    private function getExpectedSingleSerializationResult(): array
    {
        return [
            'data' => [
                'serialized!'
            ]
        ];
    }

    private function getExpectedMultiSerializationResult(): array
    {
        return [
            'data' => [
                ['serialized!'],
                ['serialized!']
            ]
        ];
    }
}
