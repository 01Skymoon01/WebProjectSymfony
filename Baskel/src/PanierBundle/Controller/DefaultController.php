<?php

namespace PanierBundle\Controller;

use PanierBundle\Entity\Commande;
use PanierBundle\Entity\DetailsCommande;
use Produits\ProduitsBundle\Entity\Mail;
use Produits\ProduitsBundle\Entity\Wishlist;
use Symfony\Component\HttpFoundation\Response;
use Produits\ProduitsBundle\Entity\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Panier/Default/index.html.twig');
    }

    public function CountPanierAction(Request $request)
    {


        $session = $request->getSession();
        if (!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier'); //$panier[ID du produit] => Quantite


        $session->set('panier',$panier);

        //Count Items Panier
        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));
        //*******************
        $usr = $this->get('security.token_storage')->getToken()->getUser();

        //Count Items Wishlist
        $Wishi = $this -> getDoctrine()
            -> getRepository(Wishlist::class)
            ->findAll();

        //******************
        return new Response(json_encode(array( 'articles'=>$articles,'Wishi'=>count($Wishi))));
    }
    public function afficherProduitsAction(Request $request)
    {
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
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
            -> getRepository(Produits::class)
            ->findAll();

        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
       $nbr = count($session->get('panier'));
       if($nbr >= 1 )
        $produits = $em->getRepository('ProduitsBundle:Produits')->findBy(array('ref_p' => array_keys($session->get('panier'))));
       else $produits =array();

        return $this->render('@Panier/Default/MyCart.html.twig', array('produit' => $produits,'panier' =>$session->get('panier')));
    }



    public function ModifierQteAction(Request $request )
    {

        $id=$request->get('ref');
        $value = $this->getDoctrine()->getManager()->getRepository('ProduitsBundle:Produits')->find($id);
        $quantite=$value->getQuantiteP();

        $session = $request->getSession();


        if (!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier'); //$panier[ID du produit] => Quantite


         $panier[$id] = $request->query->get('qte');

        $session->set('panier',$panier);

        //Calcule totale:
        $total=0;
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('ProduitsBundle:Produits')->findBy(array('ref_p' => array_keys($session->get('panier'))));
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

        return new Response(json_encode(array( 'id' => $id,'total'=>$total,'articles'=>$articles,'quantite'=>$quantite,
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
        $produits = $em->getRepository('ProduitsBundle:Produits')->findBy(array('ref_p' => array_keys($session->get('panier'))));
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



    public function ValiderAction(Request $request)
    {
        $user = $this->getUser();

        $session = $request->getSession();
        $panier = $session->get('panier');
        //Calcule totale:
        $total=0;
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('ProduitsBundle:Produits')->findBy(array('ref_p' => array_keys($session->get('panier'))));
        foreach ($produits as $value){
            $total=$total+($value->getPrixP()* $panier[$value->getRefP()] );
        }
        $PrixTotal=$total;
        //**************
        //Count Items
        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));
        $nbr=$articles;
        //***********
        $date=new \DateTime('now');
        $Commande=new Commande();
        $Commande->setDate(new \DateTime('now'));


        $Commande->setEtat(0);
        $Commande->setIdClient($user->getId());
        $Commande->setNbrProduit($nbr);
        $Commande->setTotalPrix($PrixTotal);


        $em=$this->getDoctrine()->getManager();
        $em->persist($Commande);
        $em->flush();


        /**********************************/

        $DCommande=new DetailsCommande();
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('ProduitsBundle:Produits')->findBy(array('ref_p' => array_keys($session->get('panier'))));
        $panier = $session->get('panier');
        foreach (  $produits as $prod) {
            $em2 = $this->getDoctrine()->getManager();
            $DCommande->setIdCommande($Commande);
            $DCommande->setIdProduit($prod->getRefP());
            $DCommande->setNomProduit($prod->getNomP());
            $DCommande->setQteProduit($panier[$prod->getRefP()]);
            $DCommande->setPrixPrduit($prod->getPrixP());
            $em2->persist($DCommande);
            $em2->flush();
            $DCommande = new DetailsCommande();
        }
        $session->clear();

        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            ->findAll();



       //**********Mail
        $commande0=$this->getDoctrine()
            ->getRepository(Commande::class)
            ->find($Commande->getId());
        $DetailsCommande=$this->getDoctrine()
            ->getRepository(DetailsCommande::class)
            ->findBy(['idCommande' => $commande0 ]);
        $html = $this -> renderView('@Panier/Default/DetailsCommandeBack.html.twig', array(
                'c'=>$DetailsCommande,
                'c0'=>$commande0
            )
        );
/*        $filename="Factures";
        $pdf = $this->get("knp_snappy.pdf")->getOutputFromHtml($html);

        $mm=$user->getEmail();
            $usename='ashlynx1997@gmail.com';
            $message=\Swift_Message::newInstance()
                ->setSubject('nouvelle commande')
                ->setFrom($usename)
                ->setTo($mm)
                ->setBody('Nous nous informons que vous avez une nouvelle commande',
                    'text/html');
        $attachement = \Swift_Attachment::newInstance($pdf, $filename, 'application/pdf' );
        $message->attach($attachement);
            $this->get('mailer')->send($message);
            $this->get('session')->getFlashBag()->add('notice','Message envoyé avec success');
*/

        $session = $request->getSession();
        //$session->clear();

        return $this->render('@Panier/Default/index.html.twig', array('produit' => $produit,'panier' =>$session->get('panier')));

    }

    public function AfficherCommandeAction(Request $request){

        $PN=0;
        $Totals=0;
        $commande=$this->getDoctrine()
            ->getRepository(Commande::class)
            ->findAll();
        $NonPaye=$this->getDoctrine()
            ->getRepository(Commande::class)
            ->SelectCommandeNoPaye();
        foreach ($NonPaye as $p) {
            $PN= $PN+1;
        }

        $Paye=$this->getDoctrine()
                    ->getRepository(Commande::class)
                    ->SelectCommandePaye();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this ->get('knp_paginator');
        $result=$paginator->paginate(
            $commande,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',4)
        );
        return $this -> render('@Panier/Default/CommandeBack.html.twig', array('c'=>$result, 'nonPaye' =>$PN ,'Paye'=>$Paye));
    }

    public function ModifierEtatCommandeAction($id,$etat){


        $this->getDoctrine()
            ->getRepository(Commande::class)
            ->ModifierEtat($id,1);
        $commande0=$this->getDoctrine()
            ->getRepository(Commande::class)
            ->find($id);
        $commande=$this->getDoctrine()
            ->getRepository(DetailsCommande::class)
            ->findBy(['idCommande' => $commande0 ]);
        foreach ( $commande as $value)
        {
            $this->getDoctrine()->getRepository(Commande::class)
                ->DecrStock($value->getIdProduit(),$value->getQteProduit());
        }

        return $this->redirect($this->generateUrl('AfficherCommande'));
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

    public function AfficherDetailsCommandeAction($id){

        $commande0=$this->getDoctrine()
            ->getRepository(Commande::class)
            ->find($id);
        $commande=$this->getDoctrine()
            ->getRepository(DetailsCommande::class)
            ->findBy(['idCommande' => $commande0 ]);



        $snappy=$this->get('knp_snappy.pdf');
        $html = $this -> renderView('@Panier/Default/DetailsCommandeBack.html.twig', array(
                'c'=>$commande,
                'c0'=>$commande0
            )
        );
        $filename="Factures";

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition'=> 'attachment ; filename="' .$filename.'.pdf"'
            )
        );

    }

    public function connectAction(){



        return $this -> render('@Panier/Default/connect.html.twig');
    }

   public function TrieParColumn(Request $request){


   }

}
