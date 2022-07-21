<?php

declare(strict_types=1);

namespace App\Tests\Unit\CommandHandler\ShoppingList;

use App\Command\ShoppingList\ChangeShoppingListHashCommandInterface;
use App\CommandHandler\ShoppingList\ChangeShoppingListHashCommandHandler;
use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Entity\ShoppingList;
use App\Factory\Dto\ShoppingListDtoFactoryInterface;
use App\Repository\ShoppingListRepositoryInterface;
use App\Service\HashGeneratorServiceInterface;
use App\Tests\Unit\CommandHandler\CommandHandlerTestInterface;
use Exception;
use Monolog\Test\TestCase;

final class ChangeShoppingListHashCommandHandlerTest extends TestCase implements CommandHandlerTestInterface
{
    private HashGeneratorServiceInterface $hashGeneratorService;
    private ShoppingListDtoFactoryInterface $shoppingListDtoFactory;
    private ShoppingListRepositoryInterface $shoppingListRepository;
    private ChangeShoppingListHashCommandHandler $changeShoppingListHashCommandHandler;

    public function setUp(): void
    {
        $this->hashGeneratorService = $this->createMock(HashGeneratorServiceInterface::class);
        $this->shoppingListDtoFactory = $this->createMock(ShoppingListDtoFactoryInterface::class);
        $this->shoppingListRepository = $this->createMock(ShoppingListRepositoryInterface::class);

        $this->changeShoppingListHashCommandHandler = new ChangeShoppingListHashCommandHandler(
            $this->shoppingListRepository,
            $this->shoppingListDtoFactory,
            $this->hashGeneratorService
        );
    }

    /** @throws Exception */
    public function test_handle_success(): void
    {
        $generatedHash = 'qwerty';

        $this->hashGeneratorService
            ->expects($this->once())
            ->method('generateHash')
            ->willReturn($generatedHash);

        $changeShoppingListHashCommand = $this->createMock(ChangeShoppingListHashCommandInterface::class);
        $changeShoppingListHashCommand
            ->method('getShoppingListHash')
            ->willReturn('hash');

        $shoppingList = $this->createMock(ShoppingList::class);

        $shoppingListDto = $this->createMock(ShoppingListDtoInterface::class);

        $this->shoppingListRepository
            ->expects($this->once())
            ->method('getShoppingListByHash')
            ->with($changeShoppingListHashCommand->getShoppingListHash())
            ->willReturn($shoppingList);

        $shoppingList
            ->expects($this->once())
            ->method('updateHash')
            ->with($generatedHash);

        $this->shoppingListRepository
            ->expects($this->once())
            ->method('save')
            ->with($shoppingList, true);

        $this->shoppingListDtoFactory
            ->expects($this->once())
            ->method('create')
            ->with($shoppingList)
            ->willReturn($shoppingListDto);

        $this->changeShoppingListHashCommandHandler->handle($changeShoppingListHashCommand);
    }
}
