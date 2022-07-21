<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\HashGenerationException;
use Exception;

final class HashGeneratorService implements HashGeneratorServiceInterface
{
    public const HASH_LENGTH = 8;

    public function generateHash(): string
    {
        try {
            $hash = bin2hex(random_bytes(self::HASH_LENGTH));
        } catch (Exception $e) {
            throw new HashGenerationException();
        }

        return $hash;
    }
}
