<?php

namespace PanierBundle\Controller;

use PanierBundle\Entity\Commande;
use PanierBundle\Entity\DetailsCommande;
use PanierBundle\Entity\produits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PanierController extends Controller
{
// Affciher Les Produits

    public function afficherProduitAction(Request $request)
    {


        $session = $request->getSession();
        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));

        $produit  = $this->getDoctrine()
            -> getRepository(produits::class)
            ->findAll();

        return $this -> render('@Panier/Default/shop.html.twig', array('produit' => $produit ,
            'nbr' => $articles));
    }








}
