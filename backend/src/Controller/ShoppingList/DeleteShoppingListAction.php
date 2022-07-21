<?php

declare(strict_types=1);

namespace App\Controller\ShoppingList;

use App\CommandHandler\ShoppingList\DeleteShoppingListCommandHandlerInterface;
use App\Exception\Api\BadRequestApiException;
use App\Exception\Api\NotFoundApiException;
use App\Exception\Entity\ShoppingListIsLockedException;
use App\Exception\Entity\ShoppingListNotFoundException;
use App\Factory\Command\ShoppingList\DeleteShoppingListCommandFactoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteShoppingListAction extends AbstractController
{
    public function __construct(
        private DeleteShoppingListCommandHandlerInterface $deleteShoppingListCommandHandler,
        private DeleteShoppingListCommandFactoryInterface $deleteShoppingListCommandFactory
    ) {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundApiException
     * @throws BadRequestApiException
     */
    #[Route('api/shoppingList/{shoppingListHash}', methods: ['DELETE'])]
    public function __invoke(string $shoppingListHash): JsonResponse
    {
        try {
            $this->deleteShoppingListCommandHandler->handle(
                $this->deleteShoppingListCommandFactory->create($shoppingListHash)
            );
        } catch (ShoppingListNotFoundException) {
            throw new NotFoundApiException();
        } catch (ShoppingListIsLockedException) {
            throw new BadRequestApiException();
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
