<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingList;

use App\Command\ShoppingList\GetShoppingListCommand;

interface GetShoppingListCommandFactoryInterface
{
    public function create(string $hash): GetShoppingListCommand;
}
