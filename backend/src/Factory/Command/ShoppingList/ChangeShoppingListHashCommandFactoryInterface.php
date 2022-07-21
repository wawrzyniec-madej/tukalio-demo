<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingList;

use App\Command\ShoppingList\ChangeShoppingListHashCommandInterface;

interface ChangeShoppingListHashCommandFactoryInterface
{
    public function create(string $hash): ChangeShoppingListHashCommandInterface;
}
