<?php

namespace BaskelBundle\Controller;

use BaskelBundle\Entity\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProduitsController extends Controller
{
    public function afficherProduitsAction()
    {
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            -> FindAllProducts();

        return $this -> render('@Baskel/Produits/afficherProduits.html.twig', array('produit' => $produit));
    }


}
