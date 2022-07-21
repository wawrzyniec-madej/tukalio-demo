<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingList;

use App\Command\ShoppingList\ChangeShoppingListHashCommandInterface;
use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Exception\Entity\ShoppingListNotFoundException;
use App\Exception\HashGenerationException;
use App\Exception\InvalidCollectionElementTypeException;
use Doctrine\ORM\NonUniqueResultException;

interface ChangeShoppingListHashCommandHandlerInterface
{
    /**
     * @throws HashGenerationException
     * @throws NonUniqueResultException
     * @throws ShoppingListNotFoundException
     * @throws InvalidCollectionElementTypeException
     */
    public function handle(ChangeShoppingListHashCommandInterface $changeShoppingListHashCommand
    ): ShoppingListDtoInterface;
}
