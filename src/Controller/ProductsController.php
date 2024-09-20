<?php

namespace App\Controller;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PriceSearchFormType;
use Symfony\Component\HttpFoundation\Request;


class ProductsController extends AbstractController
{
    /**
     * @Route("/products", name="app_products")
     */
    public function index(ProductRepository $productrepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
       

        return $this->render('products/products.html.twig', [
            'controller_name' => 'ProductsController',
            'produits' => $productrepository->findAll()
        ]);
    }

     /**
     * @Route("/product/{id}", name="app_product_detail")
     */
    public function detail($id, ProductRepository $productrepository,Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
       
        
        return $this->render('products/product_detail.html.twig', [
            'controller_name' => 'ProductsController',
            'produit' => $productrepository->findOneBy(['id'=>$id])
            
        ]);
    }
}
