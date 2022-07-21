<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory\Entity;

use App\Entity\ShoppingList;
use App\Entity\ShoppingListItem;
use App\Factory\Entity\ShoppingListItemFactory;
use App\Factory\Entity\ShoppingListItemFactoryInterface;
use PHPUnit\Framework\TestCase;

final class ShoppingListItemFactoryTest extends TestCase
{
    private ShoppingListItemFactoryInterface $shoppingListItemFactory;

    public function setUp(): void
    {
        $this->shoppingListItemFactory = new ShoppingListItemFactory();
    }

    public function test_create_success(): void
    {
        $shoppingList = $this->createMock(ShoppingList::class);

        $shoppingListItem = new ShoppingListItem(
            5,
            $shoppingList,
            'name',
            false
        );

        $result = $this->shoppingListItemFactory->create(
            5,
            $shoppingList,
            'name',
            false
        );

        self::assertEquals(
            $shoppingListItem,
            $result
        );
    }
}
