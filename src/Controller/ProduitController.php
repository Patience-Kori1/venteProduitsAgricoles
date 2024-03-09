<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
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
}
