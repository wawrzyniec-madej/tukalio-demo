<?php

declare(strict_types=1);

namespace App\Validator\Constraints\ShoppingListItem;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;

final class ShoppingListItemQuantityConstraint extends Assert\Compound
{
    private const DEFAULT_MIN = 1;
    private const DEFAULT_MAX = 100;

    /**
     * @param mixed[] $options
     * @return Constraint[]
     */
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Type('integer'),
            new Assert\Range(['min' => self::DEFAULT_MIN, 'max' => self::DEFAULT_MAX])
        ];
    }
}
