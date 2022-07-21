<?php

declare(strict_types=1);

namespace App\Collection\Dto;

use App\Collection\ObjectCollection;
use App\Dto\ShoppingListItem\ShoppingListItemDtoInterface;
use App\Exception\InvalidCollectionElementTypeException;

final class ShoppingListItemDtoCollection extends ObjectCollection implements DtoCollectionInterface
{
    /**
     * @param ShoppingListItemDtoInterface[] $elements
     *
     * @throws InvalidCollectionElementTypeException
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(ShoppingListItemDtoInterface::class, $elements);
    }
}
