<?php

declare(strict_types=1);

namespace App\Controller\ShoppingList;

use App\CommandHandler\ShoppingList\PatchShoppingListCommandHandlerInterface;
use App\Dto\Response\JsonResponseDto;
use App\Exception\Api\NotFoundApiException;
use App\Exception\Api\ValidationApiException;
use App\Exception\Entity\ShoppingListNotFoundException;
use App\Exception\InvalidCollectionElementTypeException;
use App\Exception\ValidationException;
use App\Factory\Command\ShoppingList\PatchShoppingListCommandFactoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PatchShoppingListAction extends AbstractController
{
    public function __construct(
        private PatchShoppingListCommandHandlerInterface $patchShoppingListCommandHandler,
        private PatchShoppingListCommandFactoryInterface $patchShoppingListCommandFactory
    ) {
    }
    
    /**
     * @throws ValidationApiException
     * @throws NonUniqueResultException
     * @throws NotFoundApiException
     * @throws InvalidCollectionElementTypeException
     */
    #[Route('api/shoppingList/{shoppingListHash}', methods: ['PATCH'])]
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $shoppingListDto = $this->patchShoppingListCommandHandler->handle(
                $this->patchShoppingListCommandFactory->createFromRequest($request)
            );
        } catch (ShoppingListNotFoundException) {
            throw new NotFoundApiException();
        } catch (ValidationException $e) {
            throw new ValidationApiException($e);
        }

        return new JsonResponse(
            new JsonResponseDto($shoppingListDto),
            Response::HTTP_OK
        );
    }
}
