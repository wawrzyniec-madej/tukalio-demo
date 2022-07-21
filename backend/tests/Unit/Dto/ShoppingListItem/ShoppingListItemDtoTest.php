<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto\ShoppingListItem;

use App\Dto\ShoppingListItem\ShoppingListItemDto;
use App\Entity\ShoppingListItem;
use App\Helper\JsonHelper;
use App\Tests\Unit\Dto\AbstractDtoTestCase;
use Exception;

final class ShoppingListItemDtoTest extends AbstractDtoTestCase
{
    /**
     * @throws Exception
     */
    public function test_serialization_success(): void
    {
        $shoppingListItem = $this->createMock(ShoppingListItem::class);

        $shoppingListItem
            ->method('getId')
            ->willReturn(5);

        $shoppingListItem
            ->method('getName')
            ->willReturn('pietruszka');

        $shoppingListItem
            ->method('isTaken')
            ->willReturn(true);

        $shoppingListItem
            ->method('getQuantity')
            ->willReturn(4);

        $shoppingListItem
            ->method('getPositionY')
            ->willReturn(1);

        $shoppingListItemDto = new ShoppingListItemDto(
            $shoppingListItem
        );

        self::assertEquals(
            $this->getExpectedSerializationResult(),
            JsonHelper::serializeFully($shoppingListItemDto)
        );
    }

    public function getExpectedSerializationResult(): array
    {
        return [
            'id' => 5,
            'name' => 'pietruszka',
            'taken' => true,
            'quantity' => 4,
            'positionY' => 1
        ];
    }
}
