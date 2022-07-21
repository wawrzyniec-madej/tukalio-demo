<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\Entity\ShoppingList;
use App\Entity\ShoppingListItem;

interface ShoppingListItemFactoryInterface
{
    public function create(
        int $quantity,
        ShoppingList $shoppingList,
        string $name,
        bool $taken
    ): ShoppingListItem;
}
