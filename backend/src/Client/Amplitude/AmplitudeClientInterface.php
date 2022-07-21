<?php

declare(strict_types=1);

namespace App\Client\Amplitude;

use App\Event\Amplitude\AmplitudeEventInterface;
use App\Exception\Client\ClientRequestErrorException;

interface AmplitudeClientInterface
{
    /**
     * @throws ClientRequestErrorException
     */
    public function sendEvent(AmplitudeEventInterface $amplitudeEvent): void;
}
