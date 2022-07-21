<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Client\Amplitude\AmplitudeClientInterface;
use App\Container\AmplitudeEventContainerInterface;
use App\Event\Amplitude\AmplitudeEventInterface;
use App\Exception\Client\ClientRequestErrorException;
use Symfony\Component\HttpKernel\Event\TerminateEvent;

final class AmplitudeTerminateListener
{
    public function __construct(
        private AmplitudeEventContainerInterface $amplitudeEventContainer,
        private AmplitudeClientInterface $amplitudeClient
    ) {
    }

    /**
     * @throws ClientRequestErrorException
     */
    public function onKernelTerminate(TerminateEvent $terminateEvent): void
    {
        $amplitudeEventCollection = $this->amplitudeEventContainer->getAmplitudeEventCollection();

        /** @var AmplitudeEventInterface $amplitudeEvent */
        foreach ($amplitudeEventCollection as $amplitudeEvent) {
            $this->amplitudeClient->sendEvent(
                $amplitudeEvent
            );
        }
    }
}
