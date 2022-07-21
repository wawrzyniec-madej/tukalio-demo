<?php

declare(strict_types=1);

namespace App\Factory\Dto;

use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Entity\ShoppingList;
use App\Exception\InvalidCollectionElementTypeException;

interface ShoppingListDtoFactoryInterface
{
    /**
     * @throws InvalidCollectionElementTypeException
     */
    public function create(ShoppingList $shoppingList): ShoppingListDtoInterface;
}
