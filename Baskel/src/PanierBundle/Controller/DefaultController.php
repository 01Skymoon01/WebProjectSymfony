<?php

namespace PanierBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use PanierBundle\Entity\produits;
use PanierBundle\Form\Panier;
use PanierBundle\Form\produitsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Panier/Default/index.html.twig');
    }

    public function afficherProduitsAction(Request $request)
    {
        $produit = $this -> getDoctrine()
            -> getRepository(produits::class)
            ->findAll();

        $session = $request->getSession();
        //$session->clear();

        return $this->render('@Panier/Default/index.html.twig', array('produit' => $produit,'panier' =>$session->get('panier')));
    }



    public function ajouterAuPanierAction(Request $request )
    {

        $id=$request->get('ref');
        $session = $request->getSession();


        if (!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier'); //$panier[ID du produit] => Quantite

        if (array_key_exists($id, $panier)) {
            $etat=1;
        }
        else{
            $etat=0;
            $panier[$id] = 1;

        }
        $session->set('panier',$panier);

        //Count Items
        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));
        //***********
        return new Response(json_encode(array( 'id' => $id,'articles'=>$articles,'etat'=>$etat,
            'panier' => $session->get('panier'))));

    }
    public function MyCartAction(Request $request)
    {
        $produit = $this -> getDoctrine()
            -> getRepository(produits::class)
            ->findAll();

        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('PanierBundle:produits')->findBy(array('refP' => array_keys($session->get('panier'))));




        return $this->render('@Panier/Default/MyCart.html.twig', array('produit' => $produits,'panier' =>$session->get('panier')));
    }


    public function ModifierQteAction(Request $request )
    {

        $id=$request->get('ref');
        $session = $request->getSession();


        if (!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier'); //$panier[ID du produit] => Quantite


         $panier[$id] = $request->query->get('qte');

        $session->set('panier',$panier);

        //Calcule totale:
        $total=0;
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('PanierBundle:produits')->findBy(array('refP' => array_keys($session->get('panier'))));
        foreach ($produits as $value){
            $total=$total+($value->getPrixP()* $panier[$value->getRefP()] );
        }

        //**************
        //Count Items
        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));
        //***********

        return new Response(json_encode(array( 'id' => $id,'total'=>$total,'articles'=>$articles,
            'panier' => $session->get('panier'))));

    }
    public function SupprimerItemAction(Request $request){
        $id=$request->get('ref');
        $session = $request->getSession();
        $panier = $session->get('panier');


            unset($panier[$id]);
            $session->set('panier',$panier);

            //Calcule totale:
        $total=0;
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('PanierBundle:produits')->findBy(array('refP' => array_keys($session->get('panier'))));
        foreach ($produits as $value){
            $total=$total+($value->getPrixP()* $panier[$value->getRefP()] );
        }

            //**************

        //Count Items
        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));
        //***********
        return new Response(json_encode(array( 'id' => $id,'total'=>$total,'articles'=>$articles,
            'panier' => $session->get('panier'))));


    }

}
