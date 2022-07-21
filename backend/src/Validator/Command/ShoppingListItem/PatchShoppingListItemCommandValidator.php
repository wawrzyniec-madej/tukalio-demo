<?php

declare(strict_types=1);

namespace App\Validator\Command\ShoppingListItem;

use App\Validator\AbstractValidator;
use App\Validator\Constraints\ShoppingListItem\ShoppingListItemNameConstraint;
use App\Validator\Constraints\ShoppingListItem\ShoppingListItemQuantityConstraint;
use Symfony\Component\Validator\Constraints as Assert;

final class PatchShoppingListItemCommandValidator extends AbstractValidator implements
    PatchShoppingListItemCommandValidatorInterface
{
    public function validate(array $data): void
    {
        $this->validateWithConstraints($data, $this->getConstraints());
    }

    public function getConstraints(): array
    {
        return [
            new Assert\Collection([
                'fields' => [
                    'shoppingListHash' => new Assert\Type('string'),
                    'shoppingListItemId' => new Assert\Type('numeric'),
                    'name' => new Assert\Optional(
                        new ShoppingListItemNameConstraint()
                    ),
                    'quantity' => new Assert\Optional(
                        new ShoppingListItemQuantityConstraint()
                    ),
                    'taken' => new Assert\Optional(
                        new Assert\Type('bool')
                    ),
                    'positionY' => new Assert\Optional(
                        new Assert\Type('integer')
                    )
                ]
            ])
        ];
    }
}
