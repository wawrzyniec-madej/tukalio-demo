<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto\ShoppingList;

use App\Collection\Dto\ShoppingListItemDtoCollection;
use App\Dto\ShoppingList\ShoppingListDto;
use App\Entity\ShoppingList;
use App\Helper\JsonHelper;
use App\Tests\Unit\Dto\AbstractDtoTestCase;
use Exception;

final class ShoppingListDtoTest extends AbstractDtoTestCase
{
    /**
     * @throws Exception
     */
    public function test_serialization_success(): void
    {
        $shoppingList = $this->createMock(ShoppingList::class);
        $shoppingList
            ->method('getHash')
            ->willReturn('22e');

        $shoppingList
            ->method('getName')
            ->willReturn('lista');

        $shoppingListDto = new ShoppingListDto(
            $shoppingList,
            new ShoppingListItemDtoCollection()
        );

        self::assertEquals(
            $this->getExpectedSerializationResult(),
            JsonHelper::serializeFully($shoppingListDto)
        );
    }

    public function getExpectedSerializationResult(): array
    {
        return [
            'hash' => '22e',
            'name' => 'lista',
            'shoppingListItems' => []
        ];
    }
}
