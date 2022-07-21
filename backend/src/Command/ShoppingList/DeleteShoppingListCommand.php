<?php

declare(strict_types=1);

namespace App\Command\ShoppingList;

final class DeleteShoppingListCommand implements DeleteShoppingListCommandInterface
{
    public function __construct(
        private string $shoppingListHash
    ) {
    }

    public function getShoppingListHash(): string
    {
        return $this->shoppingListHash;
    }
}
