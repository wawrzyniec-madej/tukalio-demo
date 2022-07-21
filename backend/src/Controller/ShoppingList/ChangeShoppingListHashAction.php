<?php

declare(strict_types=1);

namespace App\Controller\ShoppingList;

use App\CommandHandler\ShoppingList\ChangeShoppingListHashCommandHandlerInterface;
use App\Dto\Response\JsonResponseDto;
use App\Exception\Api\NotFoundApiException;
use App\Exception\Entity\ShoppingListNotFoundException;
use App\Exception\HashGenerationException;
use App\Exception\InvalidCollectionElementTypeException;
use App\Factory\Command\ShoppingList\ChangeShoppingListHashCommandFactoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ChangeShoppingListHashAction extends AbstractController
{
    public function __construct(
        private ChangeShoppingListHashCommandHandlerInterface $changeShoppingListHashCommandHandler,
        private ChangeShoppingListHashCommandFactoryInterface $changeShoppingListHashCommandFactory
    ) {
    }

    /**
     * @throws HashGenerationException
     * @throws InvalidCollectionElementTypeException
     * @throws NonUniqueResultException
     * @throws NotFoundApiException
     */
    #[Route('api/shoppingList/{shoppingListHash}/changeHash', methods: ['POST'])]
    public function __invoke(string $shoppingListHash): JsonResponse
    {
        try {
            $shoppingListDto = $this->changeShoppingListHashCommandHandler->handle(
                $this->changeShoppingListHashCommandFactory->create($shoppingListHash)
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
