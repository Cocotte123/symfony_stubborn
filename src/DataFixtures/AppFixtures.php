<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\SearchPrice;
use App\Entity\Size;
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

        $user = new User();
        $user->setEmail('admin@gmail.com')
            ->setRoles(["ROLE_ADMIN"])
            //->setPassword($this->$hasher->hashPassword($user,'123456'))
            //->setPassword($hasher->hashPassword($user,'123456'))
            ->setPassword('$2y$13$ap3qK83V4AGYp9wAwklEyOyAPCbYnDPK8lhuOf552y4V3gO4Dv7JC')
            ->setName('admin')
            ->setDeliveryAdress('Adress')
            ->setIsVerified(true);
        $manager->persist($user);
        
        $product = new Product();
        for($i = 0; $i<20;$i++){
            $product = new Product();
            $product->setName("product{$i}")
                    ->setPrice('30')
                    ->setIsHighlighted(false)
                    ->setImage("product{$i}.jpg")
                    ->setXS('2')
                    ->setS('2')
                    ->setM('2')
                    ->setL('2')
                    ->setXL('2');
            $manager->persist($product);
        }
        // $manager->persist($product);

        $searchPrice = new SearchPrice();
        $searchPrice->setName('10 à 29€')
                    ->setMinLimit('10')
                    ->setMaxLimit('30')
                    ->setOrderBy('2');
            
        $manager->persist($searchPrice);
        

        $searchPrice = new SearchPrice();
        $searchPrice->setName('30 à 35€')
                    ->setMinLimit('30')
                    ->setMaxLimit('36')
                    ->setOrderBy('3');
            
        $manager->persist($searchPrice);

        $searchPrice = new SearchPrice();
        $searchPrice->setName('36 à 50€')
                    ->setMinLimit('36')
                    ->setMaxLimit('51')
                    ->setOrderBy('4');
            
        $manager->persist($searchPrice);

        $searchPrice = new SearchPrice();
        $searchPrice->setName(' ')
                    ->setMinLimit('')
                    ->setMaxLimit('')
                    ->setOrderBy('5');
            
        $manager->persist($searchPrice);

        $searchPrice = new SearchPrice();
        $searchPrice->setName('Fourchette de prix')
                    ->setMinLimit('')
                    ->setMaxLimit('')
                    ->setOrderBy('1');
            
        $manager->persist($searchPrice);

        $size = new Size();
        $size->setSize('XS')
                    ->setSizeOrder('1');
            
        $manager->persist($size);

        $size = new Size();
        $size->setSize('S')
                    ->setSizeOrder('2');
            
        $manager->persist($size);

        $size = new Size();
        $size->setSize('M')
                    ->setSizeOrder('3');
            
        $manager->persist($size);

        $size = new Size();
        $size->setSize('L')
                    ->setSizeOrder('4');
            
        $manager->persist($size);

        $size = new Size();
        $size->setSize('XL')
                    ->setSizeOrder('5');
            
        $manager->persist($size);

        $manager->flush();
    }
}
