<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Helper\JsonHelper;
use JsonException;
use LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class JsonRequestListener
{
    public function onKernelRequest(RequestEvent $requestEvent): void
    {
        $request = $requestEvent->getRequest();

        if ($request->getContentType() === 'json') {
            $this->replaceRequestPostParamsWithJson($request);
        }
    }

    private function replaceRequestPostParamsWithJson(Request $request): void
    {
        try {
            $requestContent = $request->getContent();

            if (!is_string($requestContent)) {
                throw new LogicException('Request content is not string');
            }

            $jsonBody = JsonHelper::decodeJson($requestContent);
        } catch (JsonException) {
            $jsonBody = [];
        }

        $request->request->replace($jsonBody);
    }
}
