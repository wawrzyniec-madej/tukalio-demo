<?php

declare(strict_types=1);

namespace App\CommandHandler\ShoppingList;

use App\Command\ShoppingList\CreateShoppingListCommandInterface;
use App\Container\AmplitudeEventContainerInterface;
use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Event\Amplitude\ShoppingListCreatedAmplitudeEvent;
use App\Exception\HashGenerationException;
use App\Factory\Dto\ShoppingListDtoFactoryInterface;
use App\Factory\Entity\ShoppingListFactoryInterface;
use App\Factory\ShoppingListNameFactoryInterface;
use App\Repository\ShoppingListRepositoryInterface;
use App\Service\HashGeneratorServiceInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

final class CreateShoppingListCommandHandler implements CreateShoppingListCommandHandlerInterface
{
    public function __construct(
        private ShoppingListFactoryInterface $shoppingListFactory,
        private HashGeneratorServiceInterface $hashGeneratorService,
        private ShoppingListDtoFactoryInterface $shoppingListDtoFactory,
        private ShoppingListRepositoryInterface $shoppingListRepository,
        private ShoppingListNameFactoryInterface $shoppingListNameFactory,
        private AmplitudeEventContainerInterface $amplitudeEventContainer
    ) {
    }

    public function handle(CreateShoppingListCommandInterface $createShoppingListCommand): ShoppingListDtoInterface
    {
        $shoppingListHash = $this->generateShoppingListHashUntilUnique();

        $shoppingListName = $this->shoppingListNameFactory->create();

        $shoppingList = $this->shoppingListFactory->create(
            hash: $shoppingListHash,
            name: $shoppingListName
        );

        $this->shoppingListRepository->save($shoppingList, true);

        $this->amplitudeEventContainer->addEvent(
            new ShoppingListCreatedAmplitudeEvent(
                $shoppingList->getName(),
                $shoppingList->getHash(),
                $shoppingList->getId()
            )
        );

        return $this->shoppingListDtoFactory->create($shoppingList);
    }

    /**
     * @throws NonUniqueResultException
     * @throws HashGenerationException
     * @throws NoResultException
     */
    private function generateShoppingListHashUntilUnique(): string
    {
        $shoppingListHash = $this->hashGeneratorService->generateHash();

        if (
            $this->shoppingListRepository->isShoppingListWithHash($shoppingListHash)
        ) {
            return $this->generateShoppingListHashUntilUnique();
        }

        return $shoppingListHash;
    }
}
