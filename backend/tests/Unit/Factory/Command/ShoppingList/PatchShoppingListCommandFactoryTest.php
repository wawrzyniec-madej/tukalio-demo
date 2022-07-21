<?php
declare(strict_types=1);

namespace App\Tests\Unit\Factory\Command\ShoppingList;

use App\Command\ShoppingList\PatchShoppingListCommandInterface;
use App\Factory\Command\ShoppingList\PatchShoppingListCommandFactory;
use App\Validator\Command\ShoppingList\PatchShoppingListCommandValidatorInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class PatchShoppingListCommandFactoryTest extends TestCase
{
    private PatchShoppingListCommandValidatorInterface $patchShoppingListCommandValidator;
    private PatchShoppingListCommandFactory $patchShoppingListCommandFactory;

    public function setUp(): void
    {
        $this->patchShoppingListCommandValidator = $this->createMock(PatchShoppingListCommandValidatorInterface::class);
        $this->patchShoppingListCommandFactory = new PatchShoppingListCommandFactory(
            $this->patchShoppingListCommandValidator
        );
    }

    /** @throws Exception */
    public function test_create_success(): void
    {
        $request = new Request(
            [],
            [
                'name' => 'new shopping list name'
            ],
            [
                '_route_params' => [
                    'shoppingListHash' => 'hash'
                ]
            ]
        );

        $this->patchShoppingListCommandValidator
            ->expects($this->once())
            ->method('validate');

        $result = $this->patchShoppingListCommandFactory->createFromRequest(
            $request
        );

        self::assertInstanceOf(
            PatchShoppingListCommandInterface::class,
            $result
        );
    }

}
