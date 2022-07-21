<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingListItem;

use App\Command\ShoppingListItem\CreateShoppingListItemCommand;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;

interface CreateShoppingListItemCommandFactoryInterface
{
    /**
     * @throws ValidationException
     */
    public function createFromRequest(Request $request): CreateShoppingListItemCommand;
}
