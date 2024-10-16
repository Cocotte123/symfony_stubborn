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
        
        //$product = new Product();
        //for($i = 0; $i<20;$i++){
            $product = new Product();
            $product->setName("Bluebelt")
                    ->setPrice('29.9')
                    ->setIsHighlighted(false)
                    ->setImage("833e741e457bda0c5f2dc1ce69ebb246.jpg")
                    ->setXS('2')
                    ->setS('2')
                    ->setM('2')
                    ->setL('2')
                    ->setXL('2');
            $manager->persist($product);

            $product = new Product();
            $product->setName("Pokeball")
                    ->setPrice('45.5')
                    ->setIsHighlighted(true)
                    ->setImage("e546c05c9690916f0b3ddbc06f09d237.jpg")
                    ->setXS('2')
                    ->setS('2')
                    ->setM('2')
                    ->setL('2')
                    ->setXL('2');
            $manager->persist($product);

            $product = new Product();
            $product->setName("Street")
                    ->setPrice('34.5')
                    ->setIsHighlighted(false)
                    ->setImage("2aedc70817466616e0ef7e4e0a77e851.jpg")
                    ->setXS('2')
                    ->setS('2')
                    ->setM('2')
                    ->setL('2')
                    ->setXL('2');
            $manager->persist($product);

            $product = new Product();
            $product->setName("Blackbelt")
                    ->setPrice('29.9')
                    ->setIsHighlighted(true)
                    ->setImage("Blackbelt.jpg")
                    ->setXS('2')
                    ->setS('2')
                    ->setM('2')
                    ->setL('2')
                    ->setXL('2');
            $manager->persist($product);

            $product = new Product();
            $product->setName("PinkLady")
                    ->setPrice('29.9')
                    ->setIsHighlighted(false)
                    ->setImage("PinkLady.jpg")
                    ->setXS('2')
                    ->setS('2')
                    ->setM('2')
                    ->setL('2')
                    ->setXL('2');
            $manager->persist($product);

            $product = new Product();
            $product->setName("Snow")
                    ->setPrice('32')
                    ->setIsHighlighted(false)
                    ->setImage("Snow.jpg")
                    ->setXS('2')
                    ->setS('2')
                    ->setM('2')
                    ->setL('2')
                    ->setXL('2');
            $manager->persist($product);

            $product = new Product();
            $product->setName("Greyback")
                    ->setPrice('28.5')
                    ->setIsHighlighted(false)
                    ->setImage("Greyback.jpg")
                    ->setXS('2')
                    ->setS('2')
                    ->setM('2')
                    ->setL('2')
                    ->setXL('2');
            $manager->persist($product);

            $product = new Product();
            $product->setName("BlueCloud")
                    ->setPrice('45')
                    ->setIsHighlighted(false)
                    ->setImage("BlueCloud.jpg")
                    ->setXS('2')
                    ->setS('2')
                    ->setM('2')
                    ->setL('2')
                    ->setXL('2');
            $manager->persist($product);

            $product = new Product();
            $product->setName("BornInUsa")
                    ->setPrice('59.9')
                    ->setIsHighlighted(true)
                    ->setImage("BornInUsa.jpg")
                    ->setXS('2')
                    ->setS('2')
                    ->setM('2')
                    ->setL('2')
                    ->setXL('2');
            $manager->persist($product);

            $product = new Product();
            $product->setName("GreenSchool")
                    ->setPrice('42.2')
                    ->setIsHighlighted(false)
                    ->setImage("GreenSchool.jpg")
                    ->setXS('2')
                    ->setS('2')
                    ->setM('2')
                    ->setL('2')
                    ->setXL('2');
            $manager->persist($product);
        //}
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
                    ->setMinLimit('0')
                    ->setMaxLimit('1000')
                    ->setOrderBy('5');
            
        $manager->persist($searchPrice);

        $searchPrice = new SearchPrice();
        $searchPrice->setName('Fourchette de prix')
                    ->setMinLimit('0')
                    ->setMaxLimit('1000')
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
