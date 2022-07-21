<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory\Dto;

use App\Dto\ShoppingListItem\ShoppingListItemDtoInterface;
use App\Entity\ShoppingListItem;
use App\Factory\Dto\ShoppingListItemDtoFactory;
use App\Factory\Dto\ShoppingListItemDtoFactoryInterface;
use PHPUnit\Framework\TestCase;

final class ShoppingListItemDtoFactoryTest extends TestCase
{
    private ShoppingListItemDtoFactoryInterface $shoppingListItemDtoFactory;

    public function setUp(): void
    {
        $this->shoppingListItemDtoFactory = new ShoppingListItemDtoFactory();
    }

    public function test_create_success(): void
    {
        $shoppingListItem = $this->createMock(ShoppingListItem::class);

        $result = $this->shoppingListItemDtoFactory->create(
            $shoppingListItem
        );

        self::assertInstanceOf(
            ShoppingListItemDtoInterface::class,
            $result
        );
    }
}
