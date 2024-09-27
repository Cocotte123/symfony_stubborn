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

        foreach($panier as $id => $quantity){
            $product = $productRepository->find($id);
            $contenuPanier[] = [
                "orderedProduct" => $product,
                "orderedQuantity" => $quantity,
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
     * @Route("/add/{id}", name="add")
     */
    public function add($id,$size, SessionInterface $session, ProductRepository $productRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        //on récupère le panier actuel
        $panier = $session->get("panier",[]);
        $id = $productRepository->findOneBy(['id'=>$id])->getId();
        
       // $id = $product->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id]=1;
        }
        

        //on sauvegarde la session
        $session -> set("panier", $panier);
      

        return $this->redirectToRoute("app_cart_cart");
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove($id, SessionInterface $session, ProductRepository $productRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        //on récupère le panier actuel
        $panier = $session->get("panier",[]);
        $id = $productRepository->findOneBy(['id'=>$id])->getId();
        
       // $id = $product->getId();

        if(!empty($panier[$id])){
            if($panier[$id]>1){
                $panier[$id]--;
            }
            else {
                unset($panier[$id]);
            }
            
        }
        

        //on sauvegarde la session
        $session -> set("panier", $panier);
      

        return $this->redirectToRoute("app_cart_cart");
    }
}
