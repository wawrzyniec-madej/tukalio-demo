<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingList;

use App\Command\ShoppingList\CreateShoppingListCommandInterface;
use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Exception\Client\ClientRequestErrorException;
use App\Exception\HashGenerationException;
use App\Exception\InvalidCollectionElementTypeException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

interface CreateShoppingListCommandHandlerInterface
{
    /**
     * @throws ClientRequestErrorException
     * @throws HashGenerationException
     * @throws NonUniqueResultException
     * @throws InvalidCollectionElementTypeException
     * @throws NoResultException
     */
    public function handle(CreateShoppingListCommandInterface $createShoppingListCommand): ShoppingListDtoInterface;
}
