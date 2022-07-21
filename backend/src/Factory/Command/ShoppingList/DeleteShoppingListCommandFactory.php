<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingList;

use App\Command\ShoppingList\DeleteShoppingListCommand;

final class DeleteShoppingListCommandFactory implements DeleteShoppingListCommandFactoryInterface
{
    public function create(string $hash): DeleteShoppingListCommand
    {
        return new DeleteShoppingListCommand($hash);
    }
}
