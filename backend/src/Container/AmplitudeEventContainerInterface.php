<?php

declare(strict_types=1);

namespace App\Container;

use App\Collection\Event\AmplitudeEventCollection;
use App\Event\Amplitude\AmplitudeEventInterface;
use App\Exception\InvalidCollectionElementTypeException;

interface AmplitudeEventContainerInterface
{
    /**
     * @throws InvalidCollectionElementTypeException
     */
    public function addEvent(AmplitudeEventInterface $amplitudeEvent): void;

    public function getAmplitudeEventCollection(): AmplitudeEventCollection;
}
