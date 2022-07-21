<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command\ShoppingList;

use App\Command\ShoppingList\GetShoppingListCommand;
use App\Tests\Unit\Command\CommandTestInterface;
use PHPUnit\Framework\TestCase;

final class GetShoppingListCommandTest extends TestCase implements CommandTestInterface
{
    public function test_getters_work(): void
    {
        $getShoppingListCommand = new GetShoppingListCommand('hash');

        self::assertEquals(
            'hash',
            $getShoppingListCommand->getShoppingListHash()
        );
    }
}
