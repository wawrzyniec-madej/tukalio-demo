<?php

declare(strict_types=1);

namespace App\Command\ShoppingList;

final class ChangeShoppingListHashCommand implements ChangeShoppingListHashCommandInterface
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
