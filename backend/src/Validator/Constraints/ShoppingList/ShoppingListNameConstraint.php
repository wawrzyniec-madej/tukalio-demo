<?php

declare(strict_types=1);

namespace App\Validator\Constraints\ShoppingList;

use App\Validator\Constraints\AbstractTextConstraint;

final class ShoppingListNameConstraint extends AbstractTextConstraint
{
    public function __construct()
    {
        parent::__construct([
            'min' => 1,
            'max' => 255
        ]);
    }
}
