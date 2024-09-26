<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\StockSize;
use App\Form\ProductAddFormType;
use App\Form\StockSizeFormType;
use App\Form\ProductModifyFormType;
use App\Repository\ProductRepository;
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
    public function index(Request $request, EntityManagerInterface $entityManager,ProductRepository $productrepository): Response
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
            //on récupère l'image
            $image = $productAddForm->get('image')->getData();
            //on renomme l'image pour avoir un fichier unique
            $productName = $product->getName();
                             
            $fichierImage = $productName.'.'.$image->guessExtension();
            //$fichierImage = md5(uniqid()).'.'.$image->guessExtension();
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
            'produits' => $productrepository->findAll(),
           
        ]);
    }

    /**
     * @Route("/admin/{id}", name="app_admin_productedit")
     */
    public function editProduct($id,Request $request, EntityManagerInterface $entityManager,ProductRepository $productrepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        //modifier un produit
        $product = $productrepository->findOneBy(['id'=>$id]);
        //on crée le formulaire
        $productModifyForm = $this->createForm(ProductModifyFormType::class, $product);
        //on traite la requête
        $productModifyForm->handleRequest($request);
       
        //on vérifie si le formulaire est soumis et valide
        if($productModifyForm->isSubmitted() && $productModifyForm->isValid()){
            //on récupère l'image
            //$image = $productModifyForm->get('image')->getData();
            //on renomme l'image pour avoir un fichier unique
            //$fichierImage = md5(uniqid()).'.'.$image->guessExtension();
            //on insère le fichier dans le dossier uploads
            //$image->move(
            //    $this->getParameter('kernel.project_dir').'/'.'public/uploads',
            //    $fichierImage
            //);

            //$product->setImage($fichierImage);

            
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        

        return $this->render('admin/adminProductEdit.html.twig', [
            'controller_name' => 'AdminController',
            'productModifyForm' => $productModifyForm->createView(),
            
           
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="app_admin_productdelete")
     */
    public function deleteProduct($id,Request $request, EntityManagerInterface $entityManager,ProductRepository $productrepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        //supprimer un produit
        $product = $productrepository->findOneBy(['id'=>$id]);

        //on récupère le nom de l'image dans la BDD
        $suppImage = $product->getImage();
       
        //si l'image existe dans upload, on la supprime
        if($suppImage) {
            $nomSuppImage =  $this->getParameter('kernel.project_dir').'/'.'public/uploads'.'/'.$product->getImage();
            
            if(file_exists($nomSuppImage)){
                unlink($nomSuppImage);
            }
        }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');


    }

}
