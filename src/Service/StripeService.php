<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeService {

   
    //private $productRepository;
    //private $entityManager;
    //private $doctrine;
    

    //public function __constructor(ProductRepository $productRepository,EntityManagerInterface $entityManager,ManagerRegistry $doctrine)
    //{
                
    //    $this->productRepository = $productRepository;
    //    $this->entityManager = $entityManager;
    //    $this->doctrine = $doctrine;
        
   // }

    
    public function stripe(array $contenuPanier, string $panierId): string
    {
            
            
            ///////////////////////////
            //require_once '../vendor/autoload.php';
            
            
            //require_once '../secrets.php';
            $stripeSecretKey = $_ENV["STRIPE_SECRET_KEY"];

            \Stripe\Stripe::setApiKey($stripeSecretKey);
            header('Content-Type: application/json');

            $YOUR_DOMAIN = 'http://127.0.0.1:8000';

            $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [
                array_map(fn(array $contenuPanier)=>[
                    "quantity" => $contenuPanier["orderedQuantity"],
                    "price_data" => [
                        "currency" => "EUR",
                        "unit_amount" => $contenuPanier["orderedProduct"]->getPrice()*100,
                        "product_data" => [
                            "name" => $contenuPanier["orderedProduct"]->getName(),
                            "description" => $contenuPanier["size"],
                        ]
                ]],$contenuPanier)
            ],
            'mode' => 'payment',
            'metadata' => [
                'cart_id' => $panierId,
            ],
            
            'success_url' => $YOUR_DOMAIN . '/cart/pay/success',
            //'success_url' => $YOUR_DOMAIN . '/cart/pay/success?metadata={cart_id}',
            'cancel_url' => $YOUR_DOMAIN . '/cart/pay/cancel',
            ]);

            //dd($checkout_session->url);

            return $checkout_session->url;
    }
     
}