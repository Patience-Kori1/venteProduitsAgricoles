<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Form\ProduitUpdateType;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="app_produit")
     */
    public function produit(ProduitRepository  $repo): Response
    {
        $produits = $repo->findAll();
        return $this->render('produit/produit.html.twig', [
            'lesProduits' => $produits,
        ]);
    }

    /**
    * @route("/create" , name="create")
    */
    /**
    * @route("/create" , name="create")
    */
    public function create(Request $request): Response
    {
        $produit = new Produit;
        $form = $this->createForm(ProduitType::class, $produit); // creation du form
        $form -> handleRequest($request); 

        if ( $form->isSubmitted() && $form->isValid()) {
            $sendDatabase = $this->getDoctrine()
                                 ->getManager();
            $sendDatabase->persist($produit);
            $sendDatabase->flush();

            $this->addFlash('notice', 'Votre produit a été ajouté !!'); 
            return $this->redirectToRoute('showTable'); // Gère la redirection vers la page d'accueil après validation du formulaire
            return $this->redirectToRoute('showTable'); // Gère la redirection vers la page d'accueil après validation du formulaire
        }
        return $this->render('produit/formProduit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
    * @route("/update/{id}" , name="update")
    */
    public function update(Request $request, $id): Response
    {
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);  
        $form = $this->createForm(ProduitUpdateType::class, $produit); // creation du form
        $form -> handleRequest($request); 

        if ( $form->isSubmitted() && $form->isValid()) {
            $sendDatabase = $this->getDoctrine()
                                 ->getManager();
            $sendDatabase->persist($produit);
            $sendDatabase->flush();
            
            $this->addFlash('notice', 'Votre produit a été modifié !!'); 
            return $this->redirectToRoute('showTable'); // Gère la redirection vers la page d'accueil après validation du formulaire
        }
        return $this->render('produit/upDateProduit.html.twig', [
            'form' => $form->createView()
            
        ]);
    }

    /**
    * @route("/delete/{id}" , name="delete")
    */
    public function delete($id): Response
    {
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);  
            $sendDatabase = $this->getDoctrine()
                                 ->getManager();
            $sendDatabase->remove($produit);
            $sendDatabase->flush();
            
            $this->addFlash('notice', 'Votre produit a été supprimé !!'); 
            return $this->redirectToRoute('showTable'); 

    }

    /**
     * @route("/table", name= "showTable")
     */
    public function showTable(ProduitRepository  $repo):Response
    {
        $table = $repo->findAll();
        return $this->render('produit/tableProduits.html.twig', [
            'controller_name' => 'MainController',
            "datas_table" => $table,
        ]);
    }
}