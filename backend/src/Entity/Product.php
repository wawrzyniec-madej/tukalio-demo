<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Behavior\IdentifiableEntityBehavior;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product implements EntityInterface
{
    use IdentifiableEntityBehavior;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $usedTimes;

    public function __construct(
        string $name
    ){
        $this->name = $name;
        $this->usedTimes = 0;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function updateName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUsedTimes(): int
    {
        return $this->usedTimes;
    }

    public function incrementUsedTimes(): self
    {
        $this->usedTimes += 1;
        
        return $this;
    }
}
