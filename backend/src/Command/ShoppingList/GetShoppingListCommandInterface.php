<?php

declare(strict_types=1);

namespace App\Command\ShoppingList;

interface GetShoppingListCommandInterface
{
    public function getShoppingListHash(): string;
}
