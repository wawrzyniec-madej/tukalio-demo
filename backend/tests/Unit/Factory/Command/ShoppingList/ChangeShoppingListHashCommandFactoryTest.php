<?php
declare(strict_types=1);

namespace App\Tests\Unit\Factory\Command\ShoppingList;

use App\Command\ShoppingList\ChangeShoppingListHashCommandInterface;
use App\Factory\Command\ShoppingList\ChangeShoppingListHashCommandFactory;
use App\Factory\Command\ShoppingList\ChangeShoppingListHashCommandFactoryInterface;
use PHPUnit\Framework\TestCase;

final class ChangeShoppingListHashCommandFactoryTest extends TestCase
{
    private ChangeShoppingListHashCommandFactoryInterface $changeShoppingListHashCommandFactory;

    public function setUp(): void
    {
        $this->changeShoppingListHashCommandFactory = new ChangeShoppingListHashCommandFactory();
    }

    public function test_create_success(): void
    {
        $result = $this->changeShoppingListHashCommandFactory->create('hash');

        self::assertInstanceOf(
            ChangeShoppingListHashCommandInterface::class,
            $result
        );
    }

}
