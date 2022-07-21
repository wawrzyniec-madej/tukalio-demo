<?php

declare(strict_types=1);

namespace App\Command\ShoppingList;

interface PatchShoppingListCommandInterface
{
    public function getShoppingListHash(): string;

    public function getName(): ?string;
}
