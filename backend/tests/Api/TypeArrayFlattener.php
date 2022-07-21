<?php

declare(strict_types=1);

namespace App\Tests\Api;

use function is_array;

final class TypeArrayFlattener
{
    private array $typePaths = [];

    public function addTypePath(string $typePath): self
    {
        $this->typePaths[] = $typePath;

        return $this;
    }

    public function getResult(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value) && count($value) > 0) {
                foreach ($this->getResult($value) as $k => $v) {
                    $subKey = $key . '.' . $k;

                    $result[$subKey] = $this->getValue($subKey, $v);
                }
            } else {
                $result[$key] = $this->getValue($key, $value);
            }
        }

        return $result;
    }

    private function getValue(string $key, $value): mixed
    {
        if (in_array($key, $this->typePaths, true)) {
            return gettype($value);
        }

        return $value;
    }
}
