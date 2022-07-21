<?php

declare(strict_types=1);

namespace App\Controller\ShoppingListItem;

use App\CommandHandler\ShoppingListItem\PatchShoppingListItemCommandHandlerInterface;
use App\Dto\Response\JsonResponseDto;
use App\Exception\Api\NotFoundApiException;
use App\Exception\Api\ValidationApiException;
use App\Exception\Entity\ShoppingListItemNotFoundException;
use App\Exception\InvalidCollectionElementTypeException;
use App\Exception\ValidationException;
use App\Factory\Command\ShoppingListItem\PatchShoppingListItemCommandFactoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PatchShoppingListItemAction extends AbstractController
{
    public function __construct(
        private PatchShoppingListItemCommandHandlerInterface $patchShoppingListItemCommandHandler,
        private PatchShoppingListItemCommandFactoryInterface $patchShoppingListItemCommandFactory
    ) {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundApiException
     * @throws ValidationApiException
     * @throws InvalidCollectionElementTypeException
     */
    #[Route('api/shoppingList/{shoppingListHash}/shoppingListItem/{shoppingListItemId}', methods: ['PATCH'])]
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $shoppingListItemDto = $this->patchShoppingListItemCommandHandler->handle(
                $this->patchShoppingListItemCommandFactory->createFromRequest($request)
            );
        } catch (ShoppingListItemNotFoundException) {
            throw new NotFoundApiException();
        } catch (ValidationException $e) {
            throw new ValidationApiException($e);
        }

        return new JsonResponse(
            new JsonResponseDto(
                $shoppingListItemDto
            ),
            Response::HTTP_OK
        );
    }
}
