<?php

declare(strict_types=1);

namespace App\Controller\ShoppingList;

use App\CommandHandler\ShoppingList\CreateShoppingListCommandHandlerInterface;
use App\Dto\Response\JsonResponseDto;
use App\Exception\Client\ClientRequestErrorException;
use App\Exception\HashGenerationException;
use App\Exception\InvalidCollectionElementTypeException;
use App\Factory\Command\ShoppingList\CreateShoppingListCommandFactoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateShoppingListAction extends AbstractController
{
    public function __construct(
        private CreateShoppingListCommandHandlerInterface $createShoppingListCommandHandler,
        private CreateShoppingListCommandFactoryInterface $createShoppingListCommandFactory
    ) {
    }

    /**
     * @throws InvalidCollectionElementTypeException
     * @throws HashGenerationException
     * @throws NonUniqueResultException
     * @throws NoResultException
     * @throws ClientRequestErrorException
     */
    #[Route('api/shoppingList', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $shoppingListDto = $this->createShoppingListCommandHandler->handle(
            $this->createShoppingListCommandFactory->createFromRequest($request)
        );

        return new JsonResponse(
            new JsonResponseDto(
                $shoppingListDto
            ),
            Response::HTTP_CREATED
        );
    }
}
