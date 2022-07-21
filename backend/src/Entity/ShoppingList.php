<?php
declare(strict_types=1);

namespace App\Entity;

use App\Collection\Entity\ShoppingListItemCollection;
use App\Entity\Behavior\IdentifiableEntityBehavior;
use App\Exception\InvalidCollectionElementTypeException;
use App\Repository\ShoppingListRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShoppingListRepository::class)]
class ShoppingList implements EntityInterface
{
    use IdentifiableEntityBehavior;

    #[ORM\Column(type: 'string', length: 255)]
    private string $hash;

    #[ORM\OneToMany(mappedBy: 'shoppingList', targetEntity: ShoppingListItem::class, orphanRemoval: true)]
    private Collection $shoppingListItems;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'boolean')]
    private bool $isLocked;

    public function __construct(
        string $hash,
        string $name
    ) {
        $this->hash = $hash;
        $this->name = $name;
        $this->shoppingListItems = new ShoppingListItemCollection();
        $this->isLocked = false;
    }

    public function isLocked(): bool
    {
        return $this->isLocked;
    }

    public function lock(): self
    {
        $this->isLocked = true;

        return $this;
    }

    public function unlock(): self
    {
        $this->isLocked = false;

        return $this;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @throws InvalidCollectionElementTypeException
     */
    public function getShoppingListItems(): ShoppingListItemCollection
    {
        /** @var ShoppingListItem[] $shoppingListItemsArray */
        $shoppingListItemsArray = $this->shoppingListItems->toArray();

        return new ShoppingListItemCollection(
            $shoppingListItemsArray
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function updateHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function updateName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
