<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory\Entity;

use App\Entity\ShoppingList;
use App\Factory\Entity\ShoppingListFactory;
use App\Factory\Entity\ShoppingListFactoryInterface;
use PHPUnit\Framework\TestCase;

final class ShoppingListFactoryTest extends TestCase
{
    private ShoppingListFactoryInterface $shoppingListFactory;

    public function setUp(): void
    {
        $this->shoppingListFactory = new ShoppingListFactory();
    }

    public function test_create_success(): void
    {
        $shoppingList = new ShoppingList('hash', 'product');

        $result = $this->shoppingListFactory->create(
            'hash',
            'product'
        );

        self::assertEquals(
            $shoppingList,
            $result
        );
    }
}
