<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractTextConstraint extends Assert\Compound
{
    private const DEFAULT_MIN = 3;
    private const DEFAULT_MAX = 255;

    private int $min;
    private int $max;

    /**
     * @param mixed[] $options
     */
    public function __construct(array $options = [])
    {
        $this->min = array_key_exists('min', $options) ? (int)$options['min'] : self::DEFAULT_MIN;
        $this->max = array_key_exists('max', $options) ? (int)$options['max'] : self::DEFAULT_MAX;

        parent::__construct();
    }

    /**
     * @param mixed[] $options
     * @return Constraint[]
     */
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Type('string'),
            new Assert\Length(['min' => $this->min, 'max' => $this->max])
        ];
    }
}
