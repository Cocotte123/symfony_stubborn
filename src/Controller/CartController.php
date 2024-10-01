<?php

namespace App\Controller;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
        //dd(strtok($productSize,"."));
        //$xxx=explode(".",$productSize);
        //dd(explode(".",$productSize)[1]);
        
        if(isset($panier[$productSize])){
            $panier[$productSize]++; 
        }
        else{
            $panier[$productSize] =1;
        }

        //if(!empty($panier[$id])){
        //        $panier[$id]++;              
        //}else{
        //    $panier[$id] =1;
        //}
        

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
}
