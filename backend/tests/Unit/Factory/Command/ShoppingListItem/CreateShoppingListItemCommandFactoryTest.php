<?php
declare(strict_types=1);

namespace App\Tests\Unit\Factory\Command\ShoppingListItem;

use App\Command\ShoppingListItem\CreateShoppingListItemCommandInterface;
use App\Factory\Command\ShoppingListItem\CreateShoppingListItemCommandFactory;
use App\Factory\Command\ShoppingListItem\CreateShoppingListItemCommandFactoryInterface;
use App\Validator\Command\ShoppingListItem\CreateShoppingListItemCommandValidatorInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class CreateShoppingListItemCommandFactoryTest extends TestCase
{
    private CreateShoppingListItemCommandValidatorInterface $createShoppingListItemCommandValidator;
    private CreateShoppingListItemCommandFactoryInterface $createShoppingListItemCommandFactory;

    public function setUp(): void
    {
        $this->createShoppingListItemCommandValidator = $this->createMock(CreateShoppingListItemCommandValidatorInterface::class);
        $this->createShoppingListItemCommandFactory = new CreateShoppingListItemCommandFactory(
            $this->createShoppingListItemCommandValidator
        );
    }

    /** @throws Exception */
    public function test_create_success(): void
    {
        $request = new Request(
            [],
            [
                'name' => 'name',
                'quantity' => 5
            ],
            [
                '_route_params' => [
                    'shoppingListHash' => 'hash'
                ]
            ]
        );

        $this->createShoppingListItemCommandValidator
            ->expects($this->once())
            ->method('validate');

        $result = $this->createShoppingListItemCommandFactory->createFromRequest(
            $request,
            'hash'
        );

        self::assertInstanceOf(
            CreateShoppingListItemCommandInterface::class,
            $result
        );
    }
}
