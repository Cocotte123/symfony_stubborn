<?php

namespace App\Controller;

use App\Repository\ConferenceRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="app_home_page")
     */
    
    public function index(ProductRepository $productrepository): Response
    {
       return $this->render('home_page/home.html.twig', [
            'controller_name' => 'HomePageController',
            'produits' => $productrepository->findBy(['is_highlighted' => true])
        ]);
    }

    
         
}
