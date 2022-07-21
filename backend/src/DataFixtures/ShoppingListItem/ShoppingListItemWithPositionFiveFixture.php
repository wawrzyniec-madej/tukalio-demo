<?php

declare(strict_types=1);

namespace App\DataFixtures\ShoppingListItem;

use App\Entity\ShoppingList;
use App\Entity\ShoppingListItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class ShoppingListItemWithPositionFiveFixture extends Fixture
{
    public const REFERENCE = 'sli:3';

    public function load(ObjectManager $manager): void
    {
        /** @var ShoppingList $shoppingList */
        $shoppingList = $this->getReference('sl');

        $shoppingListItem = new ShoppingListItem(
            1,
            $shoppingList,
            'name',
            false
        );

        $shoppingListItem->setPositionY(5);

        $manager->persist($shoppingListItem);
        $manager->flush();

        $this->addReference(
            self::REFERENCE,
            $shoppingListItem
        );
    }
}
