<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\Entity\ShoppingList;

final class ShoppingListFactory implements ShoppingListFactoryInterface
{
    public function create(
        string $hash,
        string $name
    ): ShoppingList {
        return new ShoppingList(
            hash: $hash,
            name: $name
        );
    }
}
