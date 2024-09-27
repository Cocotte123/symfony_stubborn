<?php

namespace App\Controller;
use App\Entity\Product;

use App\Entity\Size;
use App\Entity\SearchPrice;
use App\Repository\ProductRepository;
use App\Repository\SizeRepository;
use App\Repository\SearchPriceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Component\HttpFoundation\Request;


class ProductsController extends AbstractController
{
    /**
     * @Route("/products", name="app_products")
     */
    public function index(ProductRepository $productrepository, Request $request,SearchPriceRepository $searchPriceRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $priceFrom = null;
        $priceTo = null;
       
        //recherche par tranche de prix
        $priceSelectForm = $this->createFormBuilder()
        ->add('name', EntityType::class,[
            'class'=> SearchPrice::class,
            'choice_label'=> 'name',
            'label' => false,
            'query_builder' => function (SearchPriceRepository $searchPriceRepository){return $searchPriceRepository->createQueryBuilder('s')->orderBy('s.orderBy','ASC'); },
            'attr' => ['onChange' => 'submit()'],
        ])
        ->getForm()
    ;

    $priceSelectForm -> handleRequest($request);
    if($priceSelectForm->isSubmitted() && $priceSelectForm->isValid()){
        $priceFrom = $priceSelectForm->get('name')->getData()->getMinLimit();
        $priceTo = $priceSelectForm->get('name')->getData()->getMaxLimit();
    }

    
        
        

        return $this->render('products/products.html.twig', [
            'controller_name' => 'ProductsController',
            'produits' => $productrepository->filterbyprice($priceFrom,$priceTo),
            'priceSelectForm' => $priceSelectForm->createView(),
            
        ]);
    }

     /**
     * @Route("/product/{id}", name="app_product_detail")
     */
    public function detail($id, ProductRepository $productrepository,Request $request, SizeRepository $sizerepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        //sélection de la taille
        $sizeSelectForm = $this->createFormBuilder()
            ->add('size', EntityType::class,[
                'class'=> Size::class,
                'choice_label'=> 'size',
                'label' => false,
                'placeholder'=> 'Taille',
                'query_builder' => function (SizeRepository $sizeRepository){return $sizeRepository->createQueryBuilder('s')->orderBy('s.size_order','ASC'); },
                'attr' => ['onChange' => 'submit()'],
            ])
            ->getForm()
        ;

        $sizeSelectForm -> handleRequest($request);
        if($sizeSelectForm->isSubmitted() && $sizeSelectForm->isValid()){
           $selectedSize = $sizeSelectForm->get('size')->getData()->getSize();
        }
       
        
        return $this->render('products/product_detail.html.twig', [
            'controller_name' => 'ProductsController',
            'produit' => $productrepository->findOneBy(['id'=>$id]),
            'sizeSelects' => $sizerepository->findAll(),
            'sizeSelectForm' => $sizeSelectForm->createView(),
        ]);
    }
}
