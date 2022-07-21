<?php

declare(strict_types=1);

namespace App\Factory\Command\ShoppingListItem;

use App\Command\ShoppingListItem\PatchShoppingListItemCommand;
use App\Exception\ValidationException;
use App\Validator\Command\ShoppingListItem\PatchShoppingListItemCommandValidatorInterface;
use Symfony\Component\HttpFoundation\Request;

final class PatchShoppingListItemCommandFactory implements PatchShoppingListItemCommandFactoryInterface
{
    public function __construct(
        private PatchShoppingListItemCommandValidatorInterface $patchShoppingListItemCommandValidator
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function createFromRequest(Request $request): PatchShoppingListItemCommand
    {
        $routeParameters = $request->attributes->all('_route_params');

        $data = [
            ...$routeParameters,
            ...$request->request->all()
        ];

        $this->patchShoppingListItemCommandValidator->validate($data);

        /** @var string|null $name */
        $name = $request->request->get('name');

        return new PatchShoppingListItemCommand(
            (int)$routeParameters['shoppingListItemId'],
            $routeParameters['shoppingListHash'],
            $request->request->has('quantity')
                ? (int)$request->request->get('quantity')
                : null,
            $name,
            $request->request->has('taken')
                ? (bool)$request->request->get('taken')
                : null,
            $request->request->get('positionY')
                ? (int)$request->request->get('positionY')
                : null
        );
    }
}
