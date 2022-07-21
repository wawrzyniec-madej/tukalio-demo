<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command\ShoppingList;

use App\Command\ShoppingList\PatchShoppingListCommand;
use App\Tests\Unit\Command\CommandTestInterface;
use PHPUnit\Framework\TestCase;

final class PatchShoppingListCommandTest extends TestCase implements CommandTestInterface
{
    public function test_getters_work(): void
    {
        $patchShoppingListCommand = new PatchShoppingListCommand('hash', 'name');

        self::assertEquals(
            'hash',
            $patchShoppingListCommand->getShoppingListHash()
        );

        self::assertEquals(
            'name',
            $patchShoppingListCommand->getName()
        );
    }
}
