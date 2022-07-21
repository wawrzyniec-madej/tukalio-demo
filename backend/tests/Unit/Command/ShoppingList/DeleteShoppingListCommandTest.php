<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command\ShoppingList;

use App\Command\ShoppingList\DeleteShoppingListCommand;
use App\Tests\Unit\Command\CommandTestInterface;
use PHPUnit\Framework\TestCase;

final class DeleteShoppingListCommandTest extends TestCase implements CommandTestInterface
{
    public function test_getters_work(): void
    {
        $deleteShoppingListCommand = new DeleteShoppingListCommand('hash');

        self::assertEquals(
            'hash',
            $deleteShoppingListCommand->getShoppingListHash()
        );
    }
}
