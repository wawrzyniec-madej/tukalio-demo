<?php
declare(strict_types=1);

namespace App\DataFixtures\Product;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class ProductFixtures extends Fixture
{
    public const PRODUCT_REFERENCE = 'p:1';

    public function load(ObjectManager $manager): void
    {
        $product = new Product(
            'orzechy'
        );

        $manager->persist($product);
        $manager->flush();

        $this->addReference(self::PRODUCT_REFERENCE, $product);
    }
}
