<?php

declare(strict_types=1);

namespace App\Command\ShoppingList;

final class PatchShoppingListCommand implements PatchShoppingListCommandInterface
{
    public function __construct(
        private string $shoppingListHash,
        private ?string $name
    ) {
    }

    public function getShoppingListHash(): string
    {
        return $this->shoppingListHash;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
