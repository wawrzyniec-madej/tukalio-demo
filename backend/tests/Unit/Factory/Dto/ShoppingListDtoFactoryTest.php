<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory\Dto;

use App\Collection\Entity\ShoppingListItemCollection;
use App\Dto\ShoppingListItem\ShoppingListItemDtoInterface;
use App\Entity\ShoppingList;
use App\Entity\ShoppingListItem;
use App\Factory\Dto\ShoppingListDtoFactory;
use App\Factory\Dto\ShoppingListDtoFactoryInterface;
use App\Factory\Dto\ShoppingListItemDtoFactoryInterface;
use Exception;
use PHPUnit\Framework\TestCase;

final class ShoppingListDtoFactoryTest extends TestCase
{
    private ShoppingListDtoFactoryInterface $shoppingListDtoFactory;
    private ShoppingListItemDtoFactoryInterface $shoppingListItemDtoFactory;

    public function setUp(): void
    {
        $this->shoppingListItemDtoFactory = $this->createMock(ShoppingListItemDtoFactoryInterface::class);

        $this->shoppingListDtoFactory = new ShoppingListDtoFactory(
            $this->shoppingListItemDtoFactory
        );
    }

    /** @throws Exception */
    public function test_create_success(): void
    {
        $shoppingListItem = $this->createMock(ShoppingListItem::class);

        $shoppingList = $this->createMock(ShoppingList::class);
        $shoppingList
            ->method('getShoppingListItems')
            ->willReturn(new ShoppingListItemCollection([
                $shoppingListItem
            ]));

        $shoppingListItemDto = $this->createMock(ShoppingListItemDtoInterface::class);

        $this->shoppingListItemDtoFactory
            ->expects($this->once())
            ->method('create')
            ->with($shoppingListItem)
            ->willReturn($shoppingListItemDto);

        $this->shoppingListDtoFactory->create(
            $shoppingList
        );
    }
}
