<?php

declare(strict_types=1);

namespace App\Helper;

use JsonException;
use JsonSerializable;
use LogicException;

final class JsonHelper
{
    /**
     * @return mixed[]
     * @throws JsonException
     */
    public static function decodeJson(string $content): array
    {
        $result = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($result)) {
            throw new LogicException('Json was not decoded properly');
        }

        return $result;
    }

    /**
     * @return mixed[]
     * @throws JsonException
     */
    public static function serializeFully(JsonSerializable $object): array
    {
        $result = json_decode(json_encode($object, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($result)) {
            throw new LogicException('Json was not decoded properly');
        }

        return $result;
    }

    /**
     * @param mixed[] $content
     * @throws JsonException
     */
    public static function encodeArray(array $content): string
    {
        return json_encode($content, JSON_THROW_ON_ERROR);
    }
}
