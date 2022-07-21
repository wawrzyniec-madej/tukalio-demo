<?php

declare(strict_types=1);

namespace App\Collection;

use App\Exception\InvalidCollectionElementTypeException;

abstract class ObjectCollection extends AbstractCollection
{
    private string $validClassName;

    /** @throws InvalidCollectionElementTypeException */
    public function __construct(string $validClassName, array $elements = [])
    {
        $this->validClassName = $validClassName;

        $this->validateElements($elements);
        parent::__construct($elements);
    }

    public function getValidClassName(): string
    {
        return $this->validClassName;
    }

    /**
     * @param object $element
     *
     * @throws InvalidCollectionElementTypeException
     */
    protected function validateElement($element): void
    {
        if (
            !is_object($element) ||
            !is_a($element, $this->validClassName)
        ) {
            throw new InvalidCollectionElementTypeException($element);
        }
    }
}
