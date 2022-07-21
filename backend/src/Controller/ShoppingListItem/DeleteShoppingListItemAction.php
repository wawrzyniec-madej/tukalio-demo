<?php

declare(strict_types=1);

namespace App\Controller\ShoppingListItem;

use App\CommandHandler\ShoppingListItem\DeleteShoppingListItemCommandHandlerInterface;
use App\Exception\Api\NotFoundApiException;
use App\Exception\Entity\ShoppingListItemNotFoundException;
use App\Factory\Command\ShoppingListItem\DeleteShoppingListItemCommandFactoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteShoppingListItemAction extends AbstractController
{
    public function __construct(
        private DeleteShoppingListItemCommandHandlerInterface $deleteShoppingListItemCommandHandler,
        private DeleteShoppingListItemCommandFactoryInterface $deleteShoppingListItemCommandFactory
    ) {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundApiException
     */
    #[Route('api/shoppingList/{shoppingListHash}/shoppingListItem/{shoppingListItemId}', methods: ['DELETE'])]
    public function __invoke(string $shoppingListHash, int $shoppingListItemId): JsonResponse
    {
        try {
            $this->deleteShoppingListItemCommandHandler->handle(
                $this->deleteShoppingListItemCommandFactory->create(
                    hash: $shoppingListHash,
                    id: $shoppingListItemId
                )
            );
        } catch (ShoppingListItemNotFoundException) {
            throw new NotFoundApiException();
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
