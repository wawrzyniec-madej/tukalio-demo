<?php

declare(strict_types=1);

namespace App\Collection\Event;

use App\Collection\ObjectCollection;
use App\Event\Amplitude\AmplitudeEventInterface;
use App\Exception\InvalidCollectionElementTypeException;

final class AmplitudeEventCollection extends ObjectCollection
{
    /**
     * @param AmplitudeEventInterface[] $elements
     *
     * @throws InvalidCollectionElementTypeException
     */
    public function __construct(array $elements = [])
    {
        parent::__construct(AmplitudeEventInterface::class, $elements);
    }
}
