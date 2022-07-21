<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingList;

use App\Command\ShoppingList\PatchShoppingListCommand;
use App\Validator\Command\ShoppingList\PatchShoppingListCommandValidatorInterface;
use Symfony\Component\HttpFoundation\Request;

final class PatchShoppingListCommandFactory implements PatchShoppingListCommandFactoryInterface
{
    public function __construct(
        private PatchShoppingListCommandValidatorInterface $patchShoppingListCommandValidator
    ) {
    }

    public function createFromRequest(Request $request): PatchShoppingListCommand
    {
        $routeParameters = $request->attributes->all('_route_params');

        $data = [
            ...$routeParameters,
            ...$request->request->all()
        ];

        $this->patchShoppingListCommandValidator->validate($data);

        /** @var string $name */
        $name = $request->request->get('name');

        return new PatchShoppingListCommand(
            $routeParameters['shoppingListHash'],
            $name
        );
    }
}
