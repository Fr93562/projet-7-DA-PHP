<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Brand;
use App\Entity\Product;
use App\Entity\Client;
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
        $product->setStock(100);
        $manager->persist($product);

        $product2 = new Product();
        $product2->setReference("IphouneXIV");
        $product2->setColor("Blackfake");
        $product2->setDelay(3);
        $product2->setPrice(1999);
        $product2->setStock(255);
        $product2->setBrand($brand);
        $product2->setStorage(32);
        $manager->persist($product2);

        // Creation de fixture customer

        $user= new User();
        $myArr = array("ROLE_ADMIN", "ROLE_USER");
        $user->setName("BileMo");
        $user->setRoles($myArr);
        $user->setPassword("1235");
        $manager->persist($user);

        $user2 = new User();
        $user2->setName("FakeBouygue");
        $user2->setRoles(["ROLE_USER"]);
        $user2->setPassword("5678");
        $manager->persist($user2);
        
        $user3= new User();
        $user3->setName("FakeSFR");
        $user3->setRoles(["ROLE_USER"]);
        $user3->setPassword("nonJeSuisToujoursPasUnToken");
        $manager->persist($user3);
        
        // Creation de fixture user
        
        $client = new Client();
        $client->setName("Licorne");
        $client->setUsername("Dorée");
        $client->setAddress("fake adress");
        $client->setPhoneNumber("06 15 10 15 50");
        $client->setUser($user);
        $client->addProduct($product);
        
        $manager->persist($client);

        $manager->flush();

        $client2 = new Client();
        $client2->setName("NomAdmin");
        $client2->setUsername("UsernameAdmin");
        $client2->setAddress("fake adress");
        $client2->setPhoneNumber("06 15 10 15 50");
        $client2->setUser($user2);
        $client2->addProduct($product2);
        
        $manager->persist($client2);

        $manager->flush();
    }
}
