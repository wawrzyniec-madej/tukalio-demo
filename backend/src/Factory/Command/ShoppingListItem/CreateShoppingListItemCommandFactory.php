<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingListItem;

use App\Command\ShoppingListItem\CreateShoppingListItemCommand;
use App\Validator\Command\ShoppingListItem\CreateShoppingListItemCommandValidatorInterface;
use Symfony\Component\HttpFoundation\Request;

final class CreateShoppingListItemCommandFactory implements CreateShoppingListItemCommandFactoryInterface
{
    public function __construct(
        private CreateShoppingListItemCommandValidatorInterface $createShoppingListItemDataValidator
    ) {
    }

    public function createFromRequest(Request $request): CreateShoppingListItemCommand
    {
        $routeParameters = $request->attributes->all('_route_params');

        $data = [
            ...$routeParameters,
            ...$request->request->all()
        ];

        $this->createShoppingListItemDataValidator->validate($data);

        /** @var string $name */
        $name = $request->request->get('name');

        return new CreateShoppingListItemCommand(
            $routeParameters['shoppingListHash'],
            $request->request->getInt('quantity'),
            $name
        );
    }
}
