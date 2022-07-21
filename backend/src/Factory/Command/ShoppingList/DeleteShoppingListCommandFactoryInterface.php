<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingList;

use App\Command\ShoppingList\DeleteShoppingListCommand;

interface DeleteShoppingListCommandFactoryInterface
{
    public function create(string $hash): DeleteShoppingListCommand;
}
