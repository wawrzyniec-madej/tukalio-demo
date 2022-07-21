<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command\ShoppingListItem;

use App\Command\ShoppingListItem\CreateShoppingListItemCommand;
use App\Tests\Unit\Command\CommandTestInterface;
use PHPUnit\Framework\TestCase;

final class CreateShoppingListItemCommandTest extends TestCase implements CommandTestInterface
{
    public function test_getters_work(): void
    {
        $createShoppingListItemCommand = new CreateShoppingListItemCommand('hash', 5, 'test');

        self::assertEquals(
            'hash',
            $createShoppingListItemCommand->getShoppingListHash()
        );

        self::assertEquals(
            5,
            $createShoppingListItemCommand->getQuantity()
        );

        self::assertEquals(
            'test',
            $createShoppingListItemCommand->getName()
        );
    }
}
