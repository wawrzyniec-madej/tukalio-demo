<?php
declare(strict_types=1);

namespace App\Tests\Unit\Factory\Command\ShoppingList;

use App\Command\ShoppingList\DeleteShoppingListCommandInterface;
use App\Factory\Command\ShoppingList\DeleteShoppingListCommandFactory;
use App\Factory\Command\ShoppingList\DeleteShoppingListCommandFactoryInterface;
use PHPUnit\Framework\TestCase;

final class DeleteShoppingListCommandFactoryTest extends TestCase
{
    private DeleteShoppingListCommandFactoryInterface $deleteShoppingListCommandFactory;

    public function setUp(): void
    {
        $this->deleteShoppingListCommandFactory = new DeleteShoppingListCommandFactory();
    }

    public function test_create_success(): void
    {
        $result = $this->deleteShoppingListCommandFactory->create('hash');

        self::assertInstanceOf(
            DeleteShoppingListCommandInterface::class,
            $result
        );
    }

}
