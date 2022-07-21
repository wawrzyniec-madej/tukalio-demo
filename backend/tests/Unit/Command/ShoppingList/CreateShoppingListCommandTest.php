<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command\ShoppingList;

use App\Command\ShoppingList\CreateShoppingListCommand;
use App\Command\ShoppingList\CreateShoppingListCommandInterface;
use App\Tests\Unit\Command\CommandTestInterface;
use PHPUnit\Framework\TestCase;

final class CreateShoppingListCommandTest extends TestCase implements CommandTestInterface
{
    public function test_getters_work(): void
    {
        $createShoppingListCommand = new CreateShoppingListCommand();

        self::assertInstanceOf(
            CreateShoppingListCommandInterface::class,
            $createShoppingListCommand
        );
    }
}
