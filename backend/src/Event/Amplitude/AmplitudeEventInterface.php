<?php

declare(strict_types=1);

namespace App\Event\Amplitude;

interface AmplitudeEventInterface
{
    /** @return mixed[][] */
    public function getBody(): array;
}
