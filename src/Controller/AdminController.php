<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\StockSize;
use App\Form\ProductAddFormType;
use App\Form\StockSizeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        //Nouveau produit
        //on crée un nouveau produit
        $product = new Product();
        

        //on crée le formulaire
        $productAddForm = $this->createForm(ProductAddFormType::class, $product);
        

        //on traite la requête
        $productAddForm->handleRequest($request);
        
        //dd($request);

        //on vérifie si le formulaire est soumis et valide
        if($productAddForm->isSubmitted() && $productAddForm->isValid()){

      

            //on récupère l'image
            $image = $productAddForm->get('image')->getData();
            //on renomme l'image pour avoir un fichier unique
            $fichierImage = md5(uniqid()).'.'.$image->guessExtension();
            //on insère le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('kernel.project_dir').'/'.'public/uploads',
                $fichierImage
            );

            $product->setImage($fichierImage);

            
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
