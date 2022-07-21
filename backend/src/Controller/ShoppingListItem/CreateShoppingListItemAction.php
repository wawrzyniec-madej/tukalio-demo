<?php

declare(strict_types=1);

namespace App\Controller\ShoppingListItem;

use App\CommandHandler\ShoppingListItem\CreateShoppingListItemCommandHandlerInterface;
use App\Dto\Response\JsonResponseDto;
use App\Exception\Api\NotFoundApiException;
use App\Exception\Api\ValidationApiException;
use App\Exception\Entity\ShoppingListNotFoundException;
use App\Exception\InvalidCollectionElementTypeException;
use App\Exception\ValidationException;
use App\Factory\Command\ShoppingListItem\CreateShoppingListItemCommandFactoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateShoppingListItemAction extends AbstractController
{
    public function __construct(
        private CreateShoppingListItemCommandHandlerInterface $createShoppingListItemCommandHandler,
        private CreateShoppingListItemCommandFactoryInterface $createShoppingListItemCommandFactory
    ) {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundApiException
     * @throws ORMException
     * @throws ValidationApiException
     * @throws InvalidCollectionElementTypeException
     */
    #[Route('api/shoppingList/{shoppingListHash}/shoppingListItem', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $shoppingListItemDto = $this->createShoppingListItemCommandHandler->handle(
                $this->createShoppingListItemCommandFactory->createFromRequest($request)
            );
        } catch (ShoppingListNotFoundException) {
            throw new NotFoundApiException();
        } catch (ValidationException $e) {
            throw new ValidationApiException($e);
        }

        return new JsonResponse(
            new JsonResponseDto(
                $shoppingListItemDto
            ),
            Response::HTTP_CREATED
        );
    }
}
