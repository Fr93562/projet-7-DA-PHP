<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Brand;
use App\Entity\Storage;
use App\Entity\Product;
use App\Entity\Customer;
use App\Entity\User;

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

        // Création de fixtures de product
        $product = new Product();
        $product->setReference("GalaxyFake10");
        $product->setColor("Blackfake");
        $product->setDelay(3);
        $product->setPrice(400);
        $product->setBrand($brand2);
        $product->setStorage(16);
        $manager->persist($product);

        $product2 = new Product();
        $product2->setReference("IphouneXIV");
        $product2->setColor("Blackfake");
        $product2->setDelay(3);
        $product2->setPrice(1999);
        $product2->setBrand($brand);
        $product2->setStorage(32);
        $manager->persist($product2);

        // Creation de fixture customer

        $customer1 = new Customer();
        $customer1->setName("FakeBouygue");
        $customer1->setToken("falseToken");
        //$customer1->setDateLimit(new DateTime('2000-01-01'));
        $manager->persist($customer1);
        
        $customer2= new Customer();
        $customer2->setName("FakeSFR");
        $customer2->setToken("nonJeSuisToujoursPasUnToken");
        //$customer1->setDateLimit(new DateTime('2000-01-01'));
        $manager->persist($customer2);
        
        // Creation de fixture user
        
        $user = new User();
        $user->setName("Licorne");
        $user->setUsername("Dorée");
        $user->setMail("licorne@fakemail.li");
        $user->setNumber("06 15 10 15 50");
        $user->setAddress("fake adress");
        $user->setCustomer($customer1);
        
        $manager->persist($user);

        $manager->flush();
    }
}
