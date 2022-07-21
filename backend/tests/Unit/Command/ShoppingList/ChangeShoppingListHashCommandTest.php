<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command\ShoppingList;

use App\Command\ShoppingList\ChangeShoppingListHashCommand;
use App\Tests\Unit\Command\CommandTestInterface;
use PHPUnit\Framework\TestCase;

final class ChangeShoppingListHashCommandTest extends TestCase implements CommandTestInterface
{
    public function test_getters_work(): void
    {
        $changeShoppingListHashCommand = new ChangeShoppingListHashCommand('qwerty');

        self::assertEquals(
            'qwerty',
            $changeShoppingListHashCommand->getShoppingListHash()
        );
    }
}
