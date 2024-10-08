<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture {

    public function load(ObjectManager $manager): void
    {
        
            $user = (new User())
                ->setEmail("user@gmail.com")
                ->setPassword("\\$2y\\$13\\$HYloM9qxiNvlhKfLuSGbjOr7WA.zKy.oDSIiIC..JgjkDPCTWlGGi")
                ->setName("tintin")
                ->setRoles("[]")
                ->setDeliveryAdress("adresse")
                ->setIsVerified("1");
                $manager->persist($user);
        
        $manager->flush();
    }

}