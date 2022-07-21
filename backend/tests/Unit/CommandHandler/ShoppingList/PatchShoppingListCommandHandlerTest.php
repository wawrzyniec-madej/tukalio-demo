<?php

declare(strict_types=1);

namespace App\Tests\Unit\CommandHandler\ShoppingList;

use App\Command\ShoppingList\PatchShoppingListCommandInterface;
use App\CommandHandler\ShoppingList\PatchShoppingListCommandHandler;
use App\CommandHandler\ShoppingList\PatchShoppingListCommandHandlerInterface;
use App\Container\AmplitudeEventContainerInterface;
use App\Dto\ShoppingList\ShoppingListDtoInterface;
use App\Entity\ShoppingList;
use App\Factory\Dto\ShoppingListDtoFactoryInterface;
use App\Repository\ShoppingListRepositoryInterface;
use Exception;
use PHPUnit\Framework\TestCase;

final class PatchShoppingListCommandHandlerTest extends TestCase
{
    private ShoppingListRepositoryInterface $shoppingListRepository;
    private ShoppingListDtoFactoryInterface $shoppingListDtoFactory;
    private PatchShoppingListCommandHandlerInterface $patchShoppingListCommandHandler;
    private AmplitudeEventContainerInterface $amplitudeEventContainer;

    public function setUp(): void
    {
        $this->shoppingListRepository = $this->createMock(ShoppingListRepositoryInterface::class);
        $this->shoppingListDtoFactory = $this->createMock(ShoppingListDtoFactoryInterface::class);
        $this->amplitudeEventContainer = $this->createMock(AmplitudeEventContainerInterface::class);

        $this->patchShoppingListCommandHandler = new PatchShoppingListCommandHandler(
            $this->shoppingListRepository,
            $this->shoppingListDtoFactory,
            $this->amplitudeEventContainer
        );
    }

    /** @throws Exception */
    public function test_handle_success(): void
    {
        $newName = 'name';

        $shoppingList = $this->createMock(ShoppingList::class);

        $shoppingListDto = $this->createMock(ShoppingListDtoInterface::class);

        $patchShoppingListCommand = $this->createMock(PatchShoppingListCommandInterface::class);
        $patchShoppingListCommand
            ->method('getName')->willReturn($newName);
        $patchShoppingListCommand
            ->method('getShoppingListHash')->willReturn('hash');

        $this->shoppingListRepository
            ->expects($this->once())
            ->method('getShoppingListByHash')
            ->with($patchShoppingListCommand->getShoppingListHash())
            ->willReturn($shoppingList);

        $shoppingList
            ->expects($this->once())
            ->method('updateName')
            ->with($newName);

        $this->shoppingListRepository
            ->expects($this->once())
            ->method('save')
            ->with($shoppingList, true);

        $this->amplitudeEventContainer
            ->expects($this->exactly(2))
            ->method('addEvent');

        $this->shoppingListDtoFactory
            ->expects($this->once())
            ->method('create')
            ->with($shoppingList)
            ->willReturn($shoppingListDto);

        $result = $this->patchShoppingListCommandHandler->handle(
            $patchShoppingListCommand
        );

        self::assertEquals(
            $shoppingListDto,
            $result
        );
    }
}
