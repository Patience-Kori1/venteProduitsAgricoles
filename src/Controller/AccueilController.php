<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="app_accueil")
     */
    public function accueil(): Response
    {
    
        return $this->render('accueil/accueil.html.twig', [
            'controller_name' => 'AccueilController',
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

            $this->addFlash('notice', 'Soumission réussie !!'); 
            return $this->redirectToRoute('accueil'); // Gère la redirection vers la page d'accueil après validation du formulaire
        }


        return $this->render('accueil/accueil.html.twig', [
            'form' => $form->createView()
        ]);

    }
}