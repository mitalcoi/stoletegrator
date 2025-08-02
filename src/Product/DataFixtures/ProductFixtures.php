<?php

namespace Product\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Product\Entity\Product;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (['fruits' => ['apple', 'banana'], 'vegetables' => ['carrot']] as $category => $productNames) {
            foreach ($productNames as $productName) {
                $product = new Product($productName, $category);
                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}
