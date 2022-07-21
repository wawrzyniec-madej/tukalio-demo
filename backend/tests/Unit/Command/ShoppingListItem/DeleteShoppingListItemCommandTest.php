<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command\ShoppingListItem;

use App\Command\ShoppingListItem\DeleteShoppingListItemCommand;
use App\Tests\Unit\Command\CommandTestInterface;
use PHPUnit\Framework\TestCase;

final class DeleteShoppingListItemCommandTest extends TestCase implements CommandTestInterface
{
    public function test_getters_work(): void
    {
        $deleteShoppingListItemCommand = new DeleteShoppingListItemCommand('hash', 5);

        self::assertEquals(
            'hash',
            $deleteShoppingListItemCommand->getShoppingListHash()
        );

        self::assertEquals(
            5,
            $deleteShoppingListItemCommand->getShoppingListItemId()
        );
    }
}
