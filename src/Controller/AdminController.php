<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductAddFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        //Nouveau produit
        //on crée un nouveau produit
        $product = new Product();

        //on crée le formulaire
        $productAddForm = $this->createForm(ProductAddFormType::class, $product);

        //on traite la requête
        $productAddForm->handleRequest($request);

        //on vérifie si le formulaire est soumis et valide
        if($productAddForm->isSubmitted() && $productAddForm->isValid()){

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }


        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
            'productAddForm' => $productAddForm->createView(),
        ]);
    }

    
}
