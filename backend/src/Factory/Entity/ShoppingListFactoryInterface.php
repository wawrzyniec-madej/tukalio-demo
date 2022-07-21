<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\Entity\ShoppingList;

interface ShoppingListFactoryInterface
{
    public function create(
        string $hash,
        string $name
    ): ShoppingList;
}
