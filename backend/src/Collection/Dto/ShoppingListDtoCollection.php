<?php

declare(strict_types=1);

namespace App\Collection\Dto;

use App\Collection\ObjectCollection;
use App\Dto\ShoppingList\ShoppingListDto;
use App\Exception\InvalidCollectionElementTypeException;

final class ShoppingListDtoCollection extends ObjectCollection implements DtoCollectionInterface
{
    /**
     * @param ShoppingListDto[] $elements
     *
     * @throws InvalidCollectionElementTypeException
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(ShoppingListDto::class, $elements);
    }
}
