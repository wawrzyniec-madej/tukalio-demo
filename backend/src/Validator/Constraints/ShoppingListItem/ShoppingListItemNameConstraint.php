<?php

declare(strict_types=1);

namespace App\Validator\Constraints\ShoppingListItem;

use App\Validator\Constraints\AbstractTextConstraint;

final class ShoppingListItemNameConstraint extends AbstractTextConstraint
{
    public function __construct()
    {
        parent::__construct([
            'min' => 1,
            'max' => 255
        ]);
    }
}
