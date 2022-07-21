<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingListItem;

use App\Command\ShoppingListItem\DeleteShoppingListItemCommand;

final class DeleteShoppingListItemCommandFactory implements DeleteShoppingListItemCommandFactoryInterface
{
    public function create(string $hash, int $id): DeleteShoppingListItemCommand
    {
        return new DeleteShoppingListItemCommand(
            $hash,
            $id
        );
    }
}
