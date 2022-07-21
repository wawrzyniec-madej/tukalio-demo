<?php

declare(strict_types=1);

namespace App\Container;

use App\Collection\Event\AmplitudeEventCollection;
use App\Event\Amplitude\AmplitudeEventInterface;
use App\Exception\InvalidCollectionElementTypeException;

final class AmplitudeEventContainer implements AmplitudeEventContainerInterface
{
    private AmplitudeEventCollection $amplitudeEventCollection;

    public function __construct()
    {
        $this->amplitudeEventCollection = new AmplitudeEventCollection();
    }

    /**
     * @throws InvalidCollectionElementTypeException
     */
    public function addEvent(AmplitudeEventInterface $amplitudeEvent): void
    {
        $this->amplitudeEventCollection->add($amplitudeEvent);
    }

    public function getAmplitudeEventCollection(): AmplitudeEventCollection
    {
        return $this->amplitudeEventCollection;
    }
}
