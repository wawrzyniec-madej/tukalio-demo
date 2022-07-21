<?php

declare(strict_types=1);

namespace App\Command\ShoppingListItem;

final class CreateShoppingListItemCommand implements CreateShoppingListItemCommandInterface
{
    public function __construct(
        private string $shoppingListHash,
        private int $quantity,
        private string $name
    ) {
    }

    public function getShoppingListHash(): string
    {
        return $this->shoppingListHash;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
