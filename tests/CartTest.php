<?php

namespace App\Tests;
use App\Entity\User;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;


class CartTest extends WebTestCase
{
   public function testIfProductAdded(): void
    {
        $client = static::createClient();
        
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $loggedUser = $entityManager->find(User::class,8);
        
        $client->loginUser($loggedUser);
        $crawler = $client->request('GET', '/cart/add/35/S');

        $this->assertResponseRedirects('/cart/');
    }

    public function testPayRoute() {
       
        //simuler un user connecté
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $loggedUser = $entityManager->find(User::class,8);
        
        $client->loginUser($loggedUser);

        //créer le panier
        $session = new Session(new MockFileSessionStorage());
        $session->start();
        $panier = $session->get("panier",[]);
        $productRepository = static::getContainer()->get(ProductRepository::class);
        $id = $productRepository->findOneBy(['name'=>'Bluebelt'])->getId();
        $size='S';
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
        $client->followRedirects();
        $url = $_SERVER['HTTP_HOST'];
        //dd($url);
        
        $this->assertContains($url,'checkout.stripe.com');
        //$this->assertResponseHeader('Content-Type', 'application/json');
        
    }
}
