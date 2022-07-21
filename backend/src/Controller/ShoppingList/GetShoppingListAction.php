<?php

declare(strict_types=1);

namespace App\Controller\ShoppingList;

use App\CommandHandler\ShoppingList\GetShoppingListCommandHandlerInterface;
use App\Dto\Response\JsonResponseDto;
use App\Exception\Api\NotFoundApiException;
use App\Exception\Entity\ShoppingListNotFoundException;
use App\Exception\InvalidCollectionElementTypeException;
use App\Factory\Command\ShoppingList\GetShoppingListCommandFactoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetShoppingListAction extends AbstractController
{
    public function __construct(
        private GetShoppingListCommandHandlerInterface $getShoppingListCommandHandler,
        private GetShoppingListCommandFactoryInterface $getShoppingListCommandFactory
    ) {
    }

    /**
     * @throws InvalidCollectionElementTypeException
     * @throws NonUniqueResultException
     * @throws NotFoundApiException
     */
    #[Route('api/shoppingList/{shoppingListHash}', methods: ['GET'])]
    public function __invoke(string $shoppingListHash): JsonResponse
    {
        try {
            $shoppingListDto = $this->getShoppingListCommandHandler->handle(
                $this->getShoppingListCommandFactory->create($shoppingListHash)
            );
        } catch (ShoppingListNotFoundException) {
            throw new NotFoundApiException();
        }

        return new JsonResponse(
            new JsonResponseDto($shoppingListDto),
            Response::HTTP_OK
        );
    }
}
