<?php

declare(strict_types=1);

namespace App\Entity\Behavior;

use Doctrine\ORM\Mapping as ORM;

trait VerticallyMovableEntityBehavior
{
    #[ORM\Column(type: 'integer')]
    private int $positionY;

    public function getPositionY(): int
    {
        return $this->positionY;
    }

    public function setPositionY(int $positionY): void
    {
        $this->positionY = $positionY;
    }
}
