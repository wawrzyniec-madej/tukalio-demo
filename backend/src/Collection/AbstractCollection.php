<?php

declare(strict_types=1);

namespace App\Collection;

use App\Exception\InvalidCollectionElementTypeException;
use Doctrine\Common\Collections\ArrayCollection;
use JsonException;
use JsonSerializable;

abstract class AbstractCollection extends ArrayCollection implements JsonSerializable
{
    /** @param array<object|string|int> $elements */
    public function __construct(array $elements)
    {
        parent::__construct($elements);
    }

    /**
     * @param object|string|int $element
     *
     * @throws InvalidCollectionElementTypeException
     */
    public function add($element): bool
    {
        $this->validateElement($element);

        return parent::add($element);
    }

    /**
     * @param object|string|int $element
     *
     * @throws InvalidCollectionElementTypeException
     */
    abstract protected function validateElement($element): void;

    /**
     * @param string|int $key
     * @param object|string|int $element
     *
     * @throws InvalidCollectionElementTypeException
     */
    public function set($key, $element): void
    {
        $this->validateElement($element);

        parent::set($key, $element);
    }

    /** @throws JsonException */
    public function __toString(): string
    {
        return (string)json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }

    /** @return array<mixed> */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @param array<int|object|string> $elements
     * @throws InvalidCollectionElementTypeException
     */
    protected function validateElements(array $elements): void
    {
        foreach ($elements as $element) {
            $this->validateElement($element);
        }
    }
}
