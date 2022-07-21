<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingList;

use App\Command\ShoppingList\PatchShoppingListCommand;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;

interface PatchShoppingListCommandFactoryInterface
{
    /**
     * @throws ValidationException
     */
    public function createFromRequest(Request $request): PatchShoppingListCommand;
}
