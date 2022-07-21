<?php

declare(strict_types=1);

namespace App\Validator\Command\ShoppingList;

use App\Validator\AbstractValidator;
use App\Validator\Constraints\ShoppingList\ShoppingListNameConstraint;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateShoppingListCommandValidator extends AbstractValidator implements
    CreateShoppingListCommandValidatorInterface
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
                    'name' => new ShoppingListNameConstraint()
                ]
            ])
        ];
    }
}
