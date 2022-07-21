<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingListItem;

use App\Command\ShoppingListItem\PatchShoppingListItemCommand;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;

interface PatchShoppingListItemCommandFactoryInterface
{
    /**
     * @throws ValidationException
     */
    public function createFromRequest(Request $request): PatchShoppingListItemCommand;
}
