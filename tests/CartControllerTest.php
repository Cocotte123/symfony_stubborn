<?php

namespace App\Tests;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Browserkit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;


use Stripe\Stripe;
use App\Service\StripeService;



class CartControllerTest extends WebTestCase {

    
    public function testAddRoute() {
       
        //simuler un user connecté
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $loggedUser = $userRepository->findOneById('3');
        $client->loginUser($loggedUser);
    
            
        
       
        $client->request('GET','/cart/add/5/S');
        $this->assertResponseRedirects('/cart/');
        
    }


    public function testPayRoute() {
       
        //simuler un user connecté
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $loggedUser = $userRepository->findOneById('3');
        $client->loginUser($loggedUser);

        //créer le panier
        $session = new Session(new MockFileSessionStorage());
        $session->start();
        $panier = $session->get("panier",[]);
        $productRepository = static::getContainer()->get(ProductRepository::class);
        $id = $productRepository->findOneBy(['id'=>'5'])->getId();
        $size='5';
        $productSize = $id.".".$size;
               
        if(isset($panier[$productSize])){
            $panier[$productSize]++; 
        }
        else{
            $panier[$productSize] =1;
        }
      

        //on sauvegarde la session
        $session -> set("panier", $panier);
        
            
        
       
        $client->request('GET','/cart/pay');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
    }

}