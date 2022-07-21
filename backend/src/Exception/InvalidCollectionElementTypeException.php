<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

final class InvalidCollectionElementTypeException extends Exception
{
    /**
     * @param object|string|int $element
     */
    public function __construct($element)
    {
        parent::__construct(sprintf('Element of invalid type "%s" was encountered in collection', gettype($element)));
    }
}
