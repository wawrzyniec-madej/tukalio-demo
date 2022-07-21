<?php

declare(strict_types=1);

namespace App\DataFixtures\ShoppingList;

use App\Entity\ShoppingList;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class ShoppingListNotLockedFixture extends Fixture
{
    public const REFERENCE = 'sl';
    public const HASH = 'defaultShoppingList';

    public function load(ObjectManager $manager): void
    {
        $shoppingList = new ShoppingList(
            self::HASH,
            'name'
        );

        $manager->persist($shoppingList);
        $manager->flush();

        $this->addReference(self::REFERENCE, $shoppingList);
    }
}
