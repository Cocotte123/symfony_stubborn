<?php

namespace App\Controller;
use App\Entity\Product;


use App\Repository\ProductRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Request;
use App\Service\StripeService;

/**
* @Route("/cart", name="app_cart_")
*/
class CartController extends AbstractController
{
    /**
     * @Route("/", name="cart")
     */
    public function index(SessionInterface $session,ProductRepository $productRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get("panier",[]);
    
        
        //on "fabrique" les données
        $contenuPanier = [];
        $total = 0;
        

        foreach($panier as $productSize=> $quantity){
            //dd(strtok($productSize,"."));
            $id = strtok($productSize,".");
            $product = $productRepository->find($id);
            $xxx=explode(".",$productSize);
            
            $size = ($xxx[1]);
            $contenuPanier[] = [
                "orderedProduct" => $product,
                "orderedQuantity" => $quantity,
                "size" => $size,
            ];
            
            $total += $product->getPrice() * $quantity;
        }
        
      

        return $this->render('cart/cart.html.twig', [
            'controller_name' => 'CartController',
            'contenuPanier' => $contenuPanier,
            'total' => $total,
        ]);
    }

    /**
     * @Route("/add/{id}/{size?}", name="add", defaults={"size": ""})
     */
    public function add($id,$size, SessionInterface $session, ProductRepository $productRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        //on récupère le panier actuel
        $panier = $session->get("panier",[]);
        $id = $productRepository->findOneBy(['id'=>$id])->getId();
        $productSize = $id.".".$size;
        
        
        if(isset($panier[$productSize])){
            $panier[$productSize]++; 
        }
        else{
            $panier[$productSize] =1;
        }
      

        //on sauvegarde la session
        $session -> set("panier", $panier);
        //dd($session);

        return $this->redirectToRoute("app_cart_cart");
    }

    /**
     * @Route("/remove/{id}/{size?}", name="remove")
     */
    public function remove($id,$size, SessionInterface $session, ProductRepository $productRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        //on récupère le panier actuel
        $panier = $session->get("panier",[]);
        $id = $productRepository->findOneBy(['id'=>$id])->getId();
        $productSize = $id.".".$size;
        
       // $id = $product->getId();

        if(!empty($panier[$productSize])){
            if($panier[$productSize]>1){
                $panier[$productSize]--;
            }
            else {
                unset($panier[$productSize]);
            }
            
        }
        

        //on sauvegarde la session
        $session -> set("panier", $panier);
      

        return $this->redirectToRoute("app_cart_cart");
    }

    /**
     * @Route("/pay", name="pay")
     */
    public function pay(SessionInterface $session, ProductRepository $productRepository, StripeService $stripeService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $panier = $session->get("panier",[]);
        $panierId = $session->getId();

        $contenuPanier = [];
        
        foreach($panier as $productSize=> $quantity){
            
            $id = strtok($productSize,".");
            $product = $productRepository->find($id);
            $xxx=explode(".",$productSize);
            
            $size = ($xxx[1]);
            $contenuPanier[] = [
                "orderedProduct" => $product,
                "orderedQuantity" => $quantity,
                "size" => $size,
            ];
           
            
        }
        

        $checkout_session = $stripeService->stripe($contenuPanier,$panierId);
      
        //dd($checkout_session);
        //////////////////////////////////////////////////////////////////
        return $this->redirect($checkout_session);
       
    }

    /**
     * @Route("/pay/success", name="pay_success")
     */
    public function success(Request $request,SessionInterface $session): Response
    {
       
        //on récupère le panier pour le supprimer
        $session->set("panier",[]);
          
        return $this->render('cart/success.html.twig', [
            'controller_name' => 'CartController',
            
        ]);
    }

    /**
     * @Route("/pay/cancel", name="pay_cancel")
     */
    public function cancel(): Response
    {
        return $this->render('cart/cancel.html.twig', [
            'controller_name' => 'CartController',
            
        ]);
    }

}
