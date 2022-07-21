<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingList;

use App\Command\ShoppingList\CreateShoppingListCommandInterface;
use Symfony\Component\HttpFoundation\Request;

interface CreateShoppingListCommandFactoryInterface
{
    public function createFromRequest(Request $request): CreateShoppingListCommandInterface;
}
