<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingListItem;

use App\Command\ShoppingListItem\DeleteShoppingListItemCommand;

interface DeleteShoppingListItemCommandFactoryInterface
{
    public function create(string $hash, int $id): DeleteShoppingListItemCommand;
}
