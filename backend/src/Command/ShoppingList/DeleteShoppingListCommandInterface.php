<?php

declare(strict_types=1);

namespace App\Command\ShoppingList;

interface DeleteShoppingListCommandInterface
{
    public function getShoppingListHash(): string;
}
