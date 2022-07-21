<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Behavior\IdentifiableEntityBehavior;
use App\Entity\Behavior\VerticallyMovableEntityBehavior;
use App\Repository\ShoppingListItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShoppingListItemRepository::class)]
#[ORM\Index(
    columns: ['position_y']
)]
class ShoppingListItem implements EntityInterface
{
    use IdentifiableEntityBehavior;
    use VerticallyMovableEntityBehavior;

    #[ORM\Column(type: 'integer')]
    private int $quantity;

    #[ORM\ManyToOne(targetEntity: ShoppingList::class, inversedBy: 'shoppingListItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ShoppingList $shoppingList;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'boolean')]
    private bool $taken;

    public function __construct(
        int $quantity,
        ShoppingList $shoppingList,
        string $name,
        bool $taken
    )
    {
        $this->quantity = $quantity;
        $this->shoppingList = $shoppingList;
        $this->name = $name;
        $this->taken = $taken;

        $this->setPositionY(1);
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getShoppingList(): ShoppingList
    {
        return $this->shoppingList;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isTaken(): bool
    {
        return $this->taken;
    }

    public function updateTaken(bool $taken): self
    {
        $this->taken = $taken;

        return $this;
    }

    public function updateQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function updateName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
