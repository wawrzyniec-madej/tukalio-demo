<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\Entity\ShoppingList;
use App\Entity\ShoppingListItem;

final class ShoppingListItemFactory implements ShoppingListItemFactoryInterface
{
    public function create(
        int $quantity,
        ShoppingList $shoppingList,
        string $name,
        bool $taken
    ): ShoppingListItem {
        return new ShoppingListItem(
            quantity: $quantity,
            shoppingList: $shoppingList,
            name: $name,
            taken: $taken
        );
    }
}
