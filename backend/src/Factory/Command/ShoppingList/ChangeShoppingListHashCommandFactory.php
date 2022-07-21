<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingList;

use App\Command\ShoppingList\ChangeShoppingListHashCommand;
use App\Command\ShoppingList\ChangeShoppingListHashCommandInterface;

final class ChangeShoppingListHashCommandFactory implements ChangeShoppingListHashCommandFactoryInterface
{
    public function create(string $hash): ChangeShoppingListHashCommandInterface
    {
        return new ChangeShoppingListHashCommand($hash);
    }
}
