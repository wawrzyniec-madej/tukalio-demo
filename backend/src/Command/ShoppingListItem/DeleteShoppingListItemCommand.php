<?php

declare(strict_types=1);

namespace App\Command\ShoppingListItem;

final class DeleteShoppingListItemCommand implements DeleteShoppingListItemCommandInterface
{
    public function __construct(
        private string $shoppingListHash,
        private int $shoppingListItemId
    ) {
    }

    public function getShoppingListHash(): string
    {
        return $this->shoppingListHash;
    }

    public function getShoppingListItemId(): int
    {
        return $this->shoppingListItemId;
    }
}
