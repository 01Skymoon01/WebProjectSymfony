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





    public function AjouterAction(Request $request,$refP)
    {
        $id=$refP;
        $session = $request->getSession();

        if (!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier'); //$panier[ID du produit] => Quantite


        if (array_key_exists($id, $panier)) {
            if ($request->query->get('qte') != null) $panier[$id] = $request->query->get('qte');
            $this->get('session')->getFlashBag()->add('success','Quantité modifié avec succès');
        } else {
           if ($request->query->get('qte') != null)
                $panier[$id] = $request->query->get('qte');
            else
                $panier[$id] = 1;


            $this->get('session')->getFlashBag()->add('success','Article ajouté avec succès');
        }
        $session->set('panier',$panier);

        return $this->redirect($this->generateUrl('panier'));
    }
    public function panierAction(Request $request)
    {


        $session = $request->getSession();
        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));

        if (!$session->has('panier')) $session->set('panier', array());/*
var_dump($session->get('panier'));
var_dump(array_keys($session->get('panier')));
die();*/
  $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('PanierBundle:produits')->findBy(array('refP' => array_keys($session->get('panier'))));

        return $this->render('@Panier/Default/Panier.html.twig', array('produit' => $produits,
            'panier' => $session->get('panier'),
            'nbr' => $articles));
        //return $this->render('@Panier/Default/Panier.html.twig');
    }



    public function SupprimerAction(Request $request,$refP)
    {
        $id=$refP;
        $session = $request->getSession();
        $panier = $session->get('panier');




        if (array_key_exists($id, $panier))
        {
            unset($panier[$id]);
            $session->set('panier',$panier);
            $this->get('session')->getFlashBag()->add('success','Article supprimé avec succès');
        }

        return $this->redirect($this->generateUrl('panier'));
    }

    public function afficherProduitAction(Request $request)
    {


        $session = $request->getSession();
        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));

        $produit  = $this -> getDoctrine()
            -> getRepository(produits::class)
            ->findAll();

        return $this -> render('@Panier/Default/shop.html.twig', array('produit' => $produit ,
            'nbr' => $articles));
    }

    /*************************************************************/

    public function ValiderCommandeAction(Request $request,$PrixTotal,$date,$nbr)
    {
        $date=new \DateTime('now');
        $Commande=new Commande();
        $Commande->setDate(new \DateTime('now'));
        $Commande->setEtat(0);
        $Commande->setIdClient(1);
        $Commande->setNbrProduit($nbr);
        $Commande->setTotalPrix($PrixTotal);


            $em=$this->getDoctrine()->getManager();
            $em->persist($Commande);
            $em->flush();


        /**********************************/
        $session = $request->getSession();
        $DCommande=new DetailsCommande();
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('PanierBundle:produits')->findBy(array('refP' => array_keys($session->get('panier'))));



        f
            $em2=$this->getDoctrine()->getManager();
            $DCommande->setIdCommande($Commande);
            $DCommande->setIdProduit($prod->getRefP());
            $DCommande->setNomProduit($prod->getNomP());
            $DCommande->setQteProduit(1);
            $DCommande->setPrixPrduit($prod->getPrixP());
            $em2->persist($DCommande);
            $em2->flush();
            $DCommande=new DetailsCommande();
        }




        $produit  = $this -> getDoctrine()
            -> getRepository(produits::class)
            ->findAll();

        return $this -> render('@Panier/Default/shop.html.twig', array('produit' => $produit ,
            'nbr' => 0));




    }
     public function AfficherCommandeAction(){

         $commande=$this->getDoctrine()
             ->getRepository(Commande::class)
             ->findAll();

         return $this -> render('@Panier/Default/CommandeBack.html.twig', array('c'=>$commande));
   }


    public function ModifierEtatCommandeAction($id,$etat){


        $this->getDoctrine()
            ->getRepository(Commande::class)
            ->ModifierEtat($id,1);

        return $this->redirect($this->generateUrl('AfficherCommande'));
    }


    public function AfficherDetailsCommandeAction($id){

        $commande0=$this->getDoctrine()
            ->getRepository(Commande::class)
            ->find($id);
        $commande=$this->getDoctrine()
            ->getRepository(DetailsCommande::class)
            ->findBy(['idCommande' => $commande0 ]);

        return $this -> render('@Panier/Default/DetailsCommandeBack.html.twig', array('c'=>$commande));
    }


    function SupprimerCommandeAction($id){
        $em=$this->getDoctrine()->getManager();
        $commande0=$this->getDoctrine()->getRepository(Commande::class)
            ->find($id);
        $athlete=$this->getDoctrine()->getRepository(Commande::class)->Supprimer($commande0);


        $em->flush();
        $em->remove($commande0);
        $em->flush();
        return $this->redirectToRoute('AfficherCommande');
    }




}
