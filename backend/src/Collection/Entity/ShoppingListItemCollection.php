<?php

declare(strict_types=1);

namespace App\Collection\Entity;

use App\Collection\ObjectCollection;
use App\Entity\ShoppingListItem;
use App\Exception\InvalidCollectionElementTypeException;

final class ShoppingListItemCollection extends ObjectCollection
{
    /**
     * @param ShoppingListItem[] $elements
     *
     * @throws InvalidCollectionElementTypeException
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(ShoppingListItem::class, $elements);
    }
}
