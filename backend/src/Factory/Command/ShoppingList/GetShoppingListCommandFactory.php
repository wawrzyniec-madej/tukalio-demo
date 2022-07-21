<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingList;

use App\Command\ShoppingList\GetShoppingListCommand;

final class GetShoppingListCommandFactory implements GetShoppingListCommandFactoryInterface
{
    public function create(string $hash): GetShoppingListCommand
    {
        return new GetShoppingListCommand($hash);
    }
}
