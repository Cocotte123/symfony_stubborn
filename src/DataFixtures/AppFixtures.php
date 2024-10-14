<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Product;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    
   
    
    
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('tintin2@gmail.com')
            ->setRoles([])
            //->setPassword($this->$hasher->hashPassword($user,'123456'))
            //->setPassword($hasher->hashPassword($user,'123456'))
            ->setPassword('$2y$13$ap3qK83V4AGYp9wAwklEyOyAPCbYnDPK8lhuOf552y4V3gO4Dv7JC')
            ->setName('tintin2')
            ->setDeliveryAdress('Adress')
            ->setIsVerified(true);
        $manager->persist($user);
        
        $product = new Product();
        for($i = 0; $i<20;$i++){
            $product = new Product();
            $product->setName("product{$i}")
                    ->setPrice('30')
                    ->setIsHighlighted(false)
                    ->setImage('image')
                    ->setXS('2')
                    ->setS('2')
                    ->setM('2')
                    ->setL('2')
                    ->setXL('2');
            $manager->persist($product);
        }
        // $manager->persist($product);

        $manager->flush();
    }
}
