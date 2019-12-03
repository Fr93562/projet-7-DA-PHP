<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Brand;
use App\Entity\Storage;
use App\Entity\Product;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $brand = new Brand();
        $brand->setName("AppleTest");
        $manager->persist($brand);

        $brand2 = new Brand();
        $brand2->setName("SamsungTest");
        $manager->persist($brand2);

        // Création de fixtures de storage
        $store = new Storage();
        $store->setCapacity(16);
        $manager->persist($store);

        $store2 = new Storage();
        $store2->setCapacity(0);
        $manager->persist($store2);

        // Création de fixtures de product
        $product = new Product();
        $product->setReference("GalaxyFake10");
        $product->setColor("Blackfake");
        $product->setDelay(3);
        $product->setPrice(400);
        $product->setBrand($brand2);
        $product->setStorage($store);
        $manager->persist($product);

        $product2 = new Product();
        $product2->setReference("IphouneXIV");
        $product2->setColor("Blackfake");
        $product2->setDelay(3);
        $product2->setPrice(1999);
        $product2->setBrand($brand);
        $product2->setStorage($store);
        $manager->persist($product2);

        $manager->flush();
    }
}
