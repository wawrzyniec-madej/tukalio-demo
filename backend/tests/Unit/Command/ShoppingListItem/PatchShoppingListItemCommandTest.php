<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command\ShoppingListItem;

use App\Command\ShoppingListItem\PatchShoppingListItemCommand;
use App\Tests\Unit\Command\CommandTestInterface;
use PHPUnit\Framework\TestCase;

final class PatchShoppingListItemCommandTest extends TestCase implements CommandTestInterface
{
    public function test_getters_work(): void
    {
        $patchShoppingListItemCommand = new PatchShoppingListItemCommand(
            1,
            'hash',
            5,
            'name',
            true,
            5
        );

        self::assertEquals(
            1,
            $patchShoppingListItemCommand->getShoppingListItemId()
        );

        self::assertEquals(
            'hash',
            $patchShoppingListItemCommand->getShoppingListHash()
        );

        self::assertEquals(
            5,
            $patchShoppingListItemCommand->getQuantity()
        );

        self::assertEquals(
            true,
            $patchShoppingListItemCommand->getTaken()
        );

        self::assertEquals(
            5,
            $patchShoppingListItemCommand->getPositionY()
        );
    }
}
