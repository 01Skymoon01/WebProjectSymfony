<?php

namespace PanierBundle\Controller;

use AppBundle\Entity\User;
use DateTime;
use EventBundle\Entity\Event;
use EventBundle\Entity\Partenaire;
use EventBundle\Entity\Reservation;
use LivraisonBundle\Entity\livraison;
use LivraisonBundle\Entity\Livreur;
use LivraisonBundle\Entity\Vehicule;
use PanierBundle\Entity\Commande;
use PanierBundle\Entity\DetailsCommande;
use Produits\ProduitsBundle\Entity\Mail;
use Produits\ProduitsBundle\Entity\Wishlist;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Produits\ProduitsBundle\Entity\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
     $filename="Factures";
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


        $usr = $this->get('security.token_storage')->getToken()->getUser();

        $mm=$usr->getEmail();
        $html = $html = $this -> renderView('@Panier/Default/DetailsCommandeBack.html.twig', array(
                'c'=>$commande,
                'c0'=>$commande0
            )
        );
        $filename="commande";
        $pdf = $this->get("knp_snappy.pdf")->getOutputFromHtml($html);

        $usename='ashlynx1997@gmail.com';
        $message=\Swift_Message::newInstance()
            -> setSubject(' Facture ')
            -> setFrom($usename)
            -> setTo($mm)
            -> setBody('Votre facture a ete bien traite',
                'text/html');

        $attachement = \Swift_Attachment::newInstance($pdf, $filename, 'application/pdf' );
        $message->attach($attachement);
        $this->get('mailer')->send($message);



        return $this->redirectToRoute('AfficherCommande');
    }

    public function connectAction(){



        return $this -> render('@Panier/Default/connect.html.twig');
    }

   public function TrieParColumn(Request $request){


   }
public function afficherCommandeDunUserAction(){
    $usr = $this->get('security.token_storage')->getToken()->getUser();

    $commande0=$this->getDoctrine()
        ->getRepository(Commande::class)
        ->findBy(array('idClient'=>$usr->getId()));

    $DetailsCommande=$this->getDoctrine()
        ->getRepository(DetailsCommande::class)
        ->findBy(['idCommande' => $commande0 ]);
     return $this -> render('@Panier/Default/AfficherCommandeFront.html.twig', array(
            'c'=>$DetailsCommande,
            'c0'=>$commande0
        )
    );
}

/*******************************************************************************/
public function AllCommandeJsonAction()
    {


        $commande=$this->getDoctrine()->getManager()
            ->getRepository(Commande::class)
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($commande);
        return new JsonResponse($formatted);
    }

    public function AllDetailsCommandeJsonAction($id)
    {


        $commande0=$this->getDoctrine()
            ->getRepository(Commande::class)
            ->find($id);
        $commande=$this->getDoctrine()
            ->getRepository(DetailsCommande::class)
            ->findBy(['idCommande' => $commande0 ]);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($commande);
        return new JsonResponse($formatted);
    }

    public function ReadAllCommandeJsonAction()
    {




        $commande=$this->getDoctrine()->getManager()
            ->getRepository(Commande::class)
            ->findAll();

        $data =  array();
        foreach ($commande as $key => $commandes){
            $data[$key]['id']= $commandes->getId();
            $data[$key]['idClient']= $commandes->getIdClient();
            $data[$key]['date']= $commandes->getDate()->format('Y-m-d H:i:s');
            $data[$key]['TotalePrix']= $commandes->getTotalPrix();
            $data[$key]['nbrProduit']= $commandes->getNbrProduit();
            $data[$key]['etat']= $commandes->getEtat();

        }
        return new JsonResponse($data);
    }

    public function AllProductsJsonAction()
    {


        $commande=$this->getDoctrine()
            ->getRepository(Produits::class)
            ->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($commande);
        return new JsonResponse($formatted);
    }


    public function LouayPanierCommandeJsonAction($size,$PrixTotal,$idClient){

        $Commande=new Commande();
        $Commande->setDate(new \DateTime('now'));


        $Commande->setEtat(0);
        $Commande->setIdClient($idClient);
        $Commande->setNbrProduit($size);
        $Commande->setTotalPrix($PrixTotal);


        $em=$this->getDoctrine()->getManager();
        $em->persist($Commande);
        $em->flush();
        $data =  array();

            $data[0]['id']= $Commande->getId();
            $data[0]['idClient']= $Commande->getIdClient();
            $data[0]['date']= $Commande->getDate()->format('Y-m-d H:i:s');
            $data[0]['TotalePrix']= $Commande->getTotalPrix();
            $data[0]['nbrProduit']= $Commande->getNbrProduit();
            $data[0]['etat']= $Commande->getEtat();


        return new JsonResponse($data);

    }

    public function NouayDetailsCommandeJsonAction($Commande,$getRefP,$getNomP,$getPrixP){
        $DCommande=new DetailsCommande();
        $commande0=$this->getDoctrine()
            ->getRepository(Commande::class)
            ->find($Commande);
        $em2 = $this->getDoctrine()->getManager();
        $DCommande->setIdCommande($commande0);
        $DCommande->setIdProduit($getRefP);
        $DCommande->setNomProduit($getNomP);
        $DCommande->setQteProduit(1);
        $DCommande->setPrixPrduit($getPrixP);
        $em2->persist($DCommande);
        $em2->flush();
        $data =  array();
        $data[0]['etat']= 1;


        return new JsonResponse($data);

    }

    public function DetailsJsonAction($id,$ref,$nom,$prix){
        $DCommande=new DetailsCommande();
        $commande0=$this->getDoctrine()
            ->getRepository(Commande::class)
            ->find($id);
        $em2 = $this->getDoctrine()->getManager();
        $DCommande->setIdCommande($commande0);
        $DCommande->setIdProduit($ref);
        $DCommande->setNomProduit($nom);
        $DCommande->setQteProduit(1);
        $DCommande->setPrixPrduit($prix);
        $em2->persist($DCommande);
        $em2->flush();
        $data =  array();
        $data[0]['etat']= 1;


        return new JsonResponse($data);

    }

    public function SendMailApresValiderJsonAction(){



        $mm='nour.khedher@esprit.tn';
        $usename='nour.khedher@esprit.tn';
        $message= \Swift_Message::newInstance()
            ->setSubject('nouvelle commande')
            -> setFrom('gintokiismyhusband@gmail.com')
            ->setTo($mm)
            ->setBody('Nous nous informons que vous avez une nouvelle commande',
                'text/html');

        $this->get('mailer')->send($message);
        $this->get('session')->getFlashBag()->add('notice','Message envoyé avec success');


        $data =  array();
        $data[0]['etat']= 1;


       return new JsonResponse($data);
        //return $this->redirectToRoute('AfficherCommande');
    }


    /******************** User ***********************************************/
    public function ReadAllUsersJsonAction()
    {
        $users=$this->getDoctrine()->getManager()
            ->getRepository(User::class)
            ->findAll();

        $data =  array();
        foreach ($users as $key => $user){
            $data[$key]['id']= $user->getId();
            $data[$key]['cin']= $user->getcin();
            $data[$key]['password']= $user->getPassword();
            $data[$key]['email']= $user->getEmail();
            $data[$key]['username']= $user->getUsername();


        }
        //var_dump(new JsonResponse($data));
        return new JsonResponse($data);
    }

    public function LoginAction($username, $password)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');

        $user = $user_manager->findUserByUsername($username);
        $encoder = $factory->getEncoder($user);

        $users = $this->getDoctrine()->getRepository(User::class)->findBy(array('username'=>$username));
        $bool = ($encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt())) ? "true" : "false";
        if($bool == "true" )
        {
            $normalizer = new ObjectNormalizer();
            $normalizer->setCircularReferenceLimit(2);
            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getId();
            });

            $serializer = new Serializer([$normalizer]);
            $formatted = $serializer->normalize($users);
            return new JsonResponse($formatted);
        }
        else
        {
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize(false);
            return new JsonResponse($formatted);
        }

    }


    /**************Livraison ***************************************/

    public function ReadLivreurJsonAction()
    {




        $commande=$this->getDoctrine()->getManager()
            ->getRepository(Livreur::class)
            ->findBy(array('id'=>47));

        $data =  array();
        foreach ($commande as $key => $commandes){
            $data[$key]['id']= $commandes->getId();
            $data[$key]['nom']= $commandes->getNom();
            $data[$key]['prenom']= $commandes->getPrenom();
            $data[$key]['dateNaiss']= $commandes->getDateNaiss()->format('Y-m-d H:i:s');
            $data[$key]['solde']= $commandes->getSolde();



        }
        return new JsonResponse($data);
    }



    public function ReadAllLivraisonJsonAction()
    {




        $commande=$this->getDoctrine()->getManager()
            ->getRepository(livraison::class)
            ->findAll();

        $data =  array();
        foreach ($commande as $key => $commandes){
            $data[$key]['id']= $commandes->getId();
            $data[$key]['idLivreur']= $commandes->getIdLivreur()->getId();
            $data[$key]['dateLiv']= $commandes->getDateLivraison()->format('Y-m-d H:i:s');
            $data[$key]['code']= $commandes->getCodeConf();
            $data[$key]['idCommande']= $commandes->getIdCommande()->getId();


        }
        return new JsonResponse($data);
    }


    public function EtatCommandeJsonAction()
    {


        $commande=$this->getDoctrine()->getManager()
            ->getRepository(Commande::class)
            ->findBy(array('etatLiv'=>0));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($commande);
        return new JsonResponse($formatted);
    }
    public function ConfirmerJsonAction($id){
        $DCommande=new livraison();
        $commande0=$this->getDoctrine()
            ->getRepository(livraison::class)
            ->findOneBy(array("idCommande"=>$id));
        $em2 = $this->getDoctrine()->getManager();

        $DCommande->setDateLivraison(new \DateTime('now'));
        $this->modifEtat2($id);
        $this->modifsolde(47,+2);
        $em2->persist($commande0);
        $em2->flush();
        $data =  array();
        $data[0]['etat']= 1;


        return new JsonResponse($data);

    }
    public function modifiDateLiv($id){
        $DCommande=new livraison();
        $commande0=$this->getDoctrine()
            ->getRepository(livraison::class)
            ->findOneBy(array("idCommande"=>$id));
        $em2 = $this->getDoctrine()->getManager();
        $DCommande->setDateLivraison(new \DateTime('now'));
        $em2->persist($commande0);
        $em2->flush();
    }
    public function modifEtat($id){
        $em= $this->getDoctrine()->getManager();
        $this->getDoctrine()
            ->getRepository(Commande::class)
            ->ModifierEtatLivraison($id,1);
    }


    public function modifEtat2($id){
        $em= $this->getDoctrine()->getManager();
        $this->getDoctrine()
            ->getRepository(Commande::class)
            ->ModifierEtatLivraison2($id,2);
    }

    public function modifsolde($id,$solde){
        $em= $this->getDoctrine()->getManager();
        $this->getDoctrine()
            ->getRepository(Livreur::class)
            ->ModifierSolde($id,$solde);
    }
    public function AddLivraisonJsonAction($Commande,$idLivreur){
        $livraison=new livraison();
        $commande0=$this->getDoctrine()
            ->getRepository(Commande::class)
            ->find($Commande);

        $this->modifEtat($Commande);


        $idLivreur0=$this->getDoctrine()
            ->getRepository(Livreur::class)
            ->find($idLivreur);
        $em2 = $this->getDoctrine()->getManager();
        $livraison->setIdCommande($commande0);
        $livraison->setIdLivreur($idLivreur0);
        $livraison->setDateLivraison(new \DateTime('now'));


        $em2->persist($livraison);
        $em2->flush();
        $data =  array();
        $data[0]['etat']= 1;


        return new JsonResponse($data);

    }


    public function getlivcomJsonAction($commande)
    {


        $commandes=$this->getDoctrine()
            ->getRepository(livraison::class)
            ->getCommande($commande);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($commandes);
        return new JsonResponse($formatted);
    }
    public function  coderecupAction($id){
        $em = $this->getDoctrine()->getManager();
        $livraison = $em->getRepository(livraison::class)->findOneBy(array("idCommande"=>$id));

        $this->modifEtat2($id);
        $this->modifsolde(47,2);
        $this->modifiDateLiv($id);
        $data =  array();
        $data[0]['etat']= $livraison->getCodeConf();
        // $data[1]['id']= $Reclamation->getIdR();
        //$data=1;
        return new JsonResponse($data);
    }




    //-----------------------------------------Vehicules-----------------------------------------------------------------

    public function ReadVehiculeJsonAction()
    {

        $vehicules=$this->getDoctrine()->getManager()
            ->getRepository(Vehicule::class)
            ->findBy(array('user'=>9));

        $data =  array();
        foreach ($vehicules as $key => $vehicule){
            $data[$key]['id']= $vehicule->getId();
            $data[$key]['matricule']= $vehicule->getMatricule();
            $data[$key]['marque']= $vehicule->getMarque();
            $data[$key]['type']= $vehicule->getType();

        }
        return new JsonResponse($data);
    }


    public function AjoutVehiculeJsonAction($matricule,$marque,$type){

        $vehicule=new Vehicule();





        // $userManager = $container->get('fos_user.user_manager');
        $vehicule->setMatricule($matricule);
        $vehicule->setMarque($marque);
        $vehicule->setType($type);
        $us= new Livreur();

        $us=$this->getDoctrine()->getManager()
            ->getRepository(Livreur::class)
            ->find(9);

        $vehicule->setUser($us);

        $em=$this->getDoctrine()->getManager();
        $em->persist($vehicule);
        $em->flush();
        $data =  array();
        $data[0]['etat']= 1;
        // $data[1]['id']= $Reclamation->getIdR();
        //$data=1;
        return new JsonResponse($data);

    }


    public function ModifierVehiculeJsonAction($id,$matricule,$marque,$type){

        $em = $this->getDoctrine()->getManager();
        $vehicule = $em->getRepository(Vehicule::class)->find($id);
        $vehicule->setMatricule($matricule);
        $vehicule->setMarque($marque);
        $vehicule->setType($type);
        $em=$this->getDoctrine()->getManager();
        $em->persist($vehicule);
        $em->flush();
        $data =  array();
        $data[0]['etat']= 1;
        // $data[1]['id']= $Reclamation->getIdR();
        //$data=1;
        return new JsonResponse($data);

    }



    public function SupprimerVehiculeJSONAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $vehicule = $em->getRepository(Vehicule::class)->find($id);
        $em->remove($vehicule);
        $em->flush();
        $data =  array();
        $data[0]['etat']= 1;
        // $data[1]['id']= $Reclamation->getIdR();
        //$data=1;
        return new JsonResponse($data);

    }


    /*********************************************EVENTS*****************************************************/
    public function ReadAllEventJsonAction()
    {




        $event=$this->getDoctrine()->getManager()
            ->getRepository(Event::class)
            ->findAll();

        $data =  array();
        foreach ($event as $key => $events){
            $data[$key]['id']= $events->getId();
            $data[$key]['nom']= $events->getNom();
            $data[$key]['date']= $events->getDate()->format('Y-m-d');
            $data[$key]['description']= $events->getDescription();
            $data[$key]['nbparticipants']= $events->getNbParticipants();
            $data[$key]['whyattend']= $events->getWhyattend();
            $data[$key]['image']= $events->getImage();
            $data[$key]['emailresponsable']= $events->getEmailresponsable();


        }
        return new JsonResponse($data);
    }

    public function ReadAllPartenaireJsonAction()
    {




        $partenaire=$this->getDoctrine()->getManager()
            ->getRepository(Partenaire::class)
            ->findAll();

        $data =  array();
        foreach ($partenaire as $key => $partenaires){
            $data[$key]['id']= $partenaires->getId();
            $data[$key]['nom']= $partenaires->getNom();
            $data[$key]['description']= $partenaires->getDescription();
            $data[$key]['type']= $partenaires->getType();
            $data[$key]['representant']= $partenaires->getRepresentant();



        }
        return new JsonResponse($data);
    }


    public function SupprimerReservationJSONAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository(Reservation::class)->find($id);
        $em->remove($reservation);
        $em->flush();
        $data =  array();
        $data[0]['rep']= 1;
        // $data[1]['id']= $Reclamation->getIdR();
        //$data=1;
        return new JsonResponse($data);
    }

    public function ReadAllReservationJsonAction($idClient)
    {

        $user = $this->get('fos_user.user_manager')->findUserBy(array('id' => $idClient));


        $reservation=$this->getDoctrine()->getManager()
            ->getRepository(Reservation::class)
            ->findBy(array('id_user'=>$user));

        $data =  array();
        foreach ($reservation as $key => $reservations){
            $data[$key]['id']= $reservations->getId();
            $data[$key]['etat']= $reservations->getEtat();
            if($reservations->getIdEvent()==null){
                $data[$key]['nom']= " ";
                $data[$key]['date']=" ";
            }
            else{
                $data[$key]['nom']= $reservations->getIdEvent()->getNom();
                $data[$key]['date']= $reservations->getIdEvent()->getDate()->format('Y-m-d');
            }




        }
        return new JsonResponse($data);
    }
    public function ReserverJsonAction($idEvent,$idClient){


        $user = $this->get('fos_user.user_manager')->findUserBy(array('id' => $idClient));
        $Reservation=new Reservation();
        $Event=$this->getDoctrine()
            ->getRepository(Event::class)
            ->find($idEvent);
        $em2 = $this->getDoctrine()->getManager();
        $Reservation->setIdUser($user);
        $Reservation->setIdEvent($Event);


        $em2->persist($Reservation);
        $em2->flush();
        $data =  array();
        $data[0]['rep']= 1;


        return new JsonResponse($data);

    }
}
