<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
            return $this->redirectToRoute('app_accueil'); // Gère la redirection vers la page d'accueil après validation du formulaire
        }
        return $this->render('produit/formProduit.html.twig', [
            'form' => $form->createView()
        ]);
}
}