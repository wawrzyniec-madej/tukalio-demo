<?php

declare(strict_types=1);

namespace App\Validator\Command\ShoppingListItem;

use App\Validator\AbstractValidator;
use App\Validator\Constraints\ShoppingListItem\ShoppingListItemNameConstraint;
use App\Validator\Constraints\ShoppingListItem\ShoppingListItemQuantityConstraint;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateShoppingListItemCommandValidator extends AbstractValidator implements
    CreateShoppingListItemCommandValidatorInterface
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
                    'name' => new ShoppingListItemNameConstraint(),
                    'quantity' => new ShoppingListItemQuantityConstraint()
                ]
            ])
        ];
    }
}
