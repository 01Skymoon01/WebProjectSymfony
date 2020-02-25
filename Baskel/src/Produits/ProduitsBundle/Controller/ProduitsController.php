<?php

namespace Produits\ProduitsBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use mysql_xdevapi\Session;
use Produits\ProduitsBundle\Entity\Categories;
use Produits\ProduitsBundle\Entity\Mail;
use Produits\ProduitsBundle\Entity\Produits;
use Produits\ProduitsBundle\Entity\Rating;
use Produits\ProduitsBundle\Entity\User;
use Produits\ProduitsBundle\Entity\Wishlist;
use Produits\ProduitsBundle\Form\CategoriesType;
use Produits\ProduitsBundle\Form\MailType;
use Produits\ProduitsBundle\Form\ModifierSoldeType;
use Produits\ProduitsBundle\Form\ProduitsModifType;
use Produits\ProduitsBundle\Form\ProduitsType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Produits\ProduitsBundle\Repository\WishlistRepository;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



class ProduitsController extends Controller
{
    public function shopAction(Request $request)
    {
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            ->FindAll();

        $categorie = $this -> getDoctrine()
            -> getRepository(Categories::class)
            ->findAll();

        $rating = $this -> getDoctrine()
            -> getRepository(Produits::class)
            ->FindAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this ->get('knp_paginator');
        $result=$paginator->paginate(
            $produit,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',6)
        );



        //  $this->container->get('templating');

        $user = $this->getUser();
        //**************Nour PART *************************//
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        //$session->clear();
        $nbr = count($session->get('panier'));
        if($nbr >= 1 )
            $produits = $em->getRepository('ProduitsBundle:Produits')->findBy(array('ref_p' => array_keys($session->get('panier'))));
        else $produits =array();
         //**************END Nour PART *************************//
        return $this -> render('@Produits/Produits/shop.html.twig', array('produit' => $result,'categorie' => $categorie ,'user' => $user,
            'rating' => $rating,
            'panier' =>$session->get('panier'),
            'produit1' => $produits));
    }

    public function filtrerCouleurAction(Request $request,$couleur)
    {
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            ->findAll();

        $categorie = $this -> getDoctrine()
            -> getRepository(Categories::class)
            ->findAll();


        $user = $this->getUser();

        $arrayC=array();
        $i=0;

       foreach ($produit as $value){

            foreach ($value->getCouleurP() as $ac){

                if($ac == $couleur){
                    $arrayC[$i] = $value;
                    $i++;
                }
           }
       }

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this ->get('knp_paginator');
        $result=$paginator->paginate(
            $arrayC,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',6)
        );

        //**************Nour PART *************************//
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        //$session->clear();
        $nbr = count($session->get('panier'));
        if($nbr >= 1 )
            $produits = $em->getRepository('ProduitsBundle:Produits')->findBy(array('ref_p' => array_keys($session->get('panier'))));
        else $produits =array();
        //**************END Nour PART *************************//

        return $this -> render('@Produits/Produits/filtrer.html.twig', array('produit' => $result,'categorie' => $categorie ,'user' => $user,
            'panier' =>$session->get('panier'),
            'produit1' => $produits));
    }



    public function filtrerSexeAction(Request $request,$sexe)
    {
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            ->FilterSexe($sexe);

        $categorie = $this -> getDoctrine()
            -> getRepository(Categories::class)
            ->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this ->get('knp_paginator');
        $result=$paginator->paginate(
            $produit,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',6)
        );



        //  $this->container->get('templating');

        $user = $this->getUser();
        //**************Nour PART *************************//
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        //$session->clear();
        $nbr = count($session->get('panier'));
        if($nbr >= 1 )
            $produits = $em->getRepository('ProduitsBundle:Produits')->findBy(array('ref_p' => array_keys($session->get('panier'))));
        else $produits =array();
        //**************END Nour PART *************************//

        return $this -> render('@Produits/Produits/filtrer.html.twig', array('produit' => $result,'categorie' => $categorie ,'user' => $user,
            'panier' =>$session->get('panier'),
            'produit1' => $produits));
    }








    public function  alertAction(){
        return $this -> render('@Produits/Produits/alert.html.twig');
    }

    public function filtrerPrixAction(Request $request,$prix)
    {
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            ->FilterPrix($prix);

        $categorie = $this -> getDoctrine()
            -> getRepository(Categories::class)
            ->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this ->get('knp_paginator');
        $result=$paginator->paginate(
            $produit,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',6)
        );



        //  $this->container->get('templating');

        $user = $this->getUser();

        //**************Nour PART *************************//
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        //$session->clear();
        $nbr = count($session->get('panier'));
        if($nbr >= 1 )
            $produits = $em->getRepository('ProduitsBundle:Produits')->findBy(array('ref_p' => array_keys($session->get('panier'))));
        else $produits =array();
        //**************END Nour PART *************************//

        return $this -> render('@Produits/Produits/filtrer.html.twig', array('produit' => $result,'categorie' => $categorie ,'user' => $user,
            'panier' =>$session->get('panier'),
            'produit1' => $produits));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/client/" , name="afficherProduits")
     *
     */

    public function afficherProduitsAction(Request $request)
    {
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            ->FindAllProducts();

        $categorie = $this -> getDoctrine()
            -> getRepository(Categories::class)
            ->findAll();

      //  $this->container->get('templating');

        $user = $this->getUser();
        //**************Nour PART *************************//
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        //$session->clear();
        $nbr = count($session->get('panier'));
        if($nbr >= 1 )
            $produits = $em->getRepository('ProduitsBundle:Produits')->findBy(array('ref_p' => array_keys($session->get('panier'))));
        else $produits =array();
        //**************END Nour PART *************************//

        return $this -> render('@Produits/Produits/afficherProduits.html.twig', array('produit' => $produit,'categorie' => $categorie ,'user' => $user,
            'panier' =>$session->get('panier'),
            'produit1' => $produits));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/")
     *
     * @Security("has_role('ROLES_ADMIN')")
     */

    public function ajouterCategorieAction(Request $request)
    {
        $categorie = new Categories();
        $form = $this -> createForm(CategoriesType::class, $categorie) -> handleRequest($request);
        $em = $this -> getDoctrine() -> getManager();
        $user = $this->getUser();

        if ($form -> isSubmitted() and $form -> isValid()) {
            $em -> persist($categorie);
            $em -> flush();

            return $this -> redirectToRoute('afficherCategories');

        }

        return $this -> render('@Produits/Produits/ajouterCategorie.html.twig',
            array('form' => $form -> createView(),'user' => $user));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/")
     *
     * @Security("has_role('ROLES_ADMIN')")
     */

    public function afficherCategoriesAction(Request $request)
    {
        $categorie = $this -> getDoctrine()
            -> getRepository(Categories::class)
            ->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this ->get('knp_paginator');
        $result=$paginator->paginate(
            $categorie,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',4)
        );

        $user = $this->getUser();
        //**************Nour PART *************************//
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        //$session->clear();
        $nbr = count($session->get('panier'));
        if($nbr >= 1 )
            $produits = $em->getRepository('ProduitsBundle:Produits')->findBy(array('ref_p' => array_keys($session->get('panier'))));
        else $produits =array();
        //**************END Nour PART *************************//
        return $this -> render('@Produits/Produits/afficherCategories.html.twig', array('categorie' => $result,'user'=>$user,
            'panier' =>$session->get('panier'),
            'produit1' => $produits));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/")
     *
     * @Security("has_role('ROLES_ADMIN')")
     */

    function supprimerCategorieAction($ref_c)
    {
        $em = $this -> getDoctrine() -> getManager();
        $categorie = $this -> getDoctrine()
            -> getRepository(Categories::class)
            -> find($ref_c);
        try {
            $em -> remove($categorie);
            $em -> flush();


        } catch (ForeignKeyConstraintViolationException $e){
            $this->addFlash('error',"Vous ne pouvez pas supprimer une catégorie pleine.");
        }

        return $this -> redirectToRoute('afficherCategories');
    }



    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/")
     *
     * @Security("has_role('ROLES_ADMIN')")
     */

    public function ajouterProduitAction(Request $request)
    {
        $produit = new Produits();
        $form = $this -> createForm(ProduitsType::class, $produit) -> handleRequest($request);
        $em = $this -> getDoctrine() -> getManager();
        $user = $this->getUser();


        if ($form -> isSubmitted() and $form -> isValid()) {
            /**
             * @var UploadedFile $file
             */

            $file = $produit->getImage();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );

            $produit->setImage($fileName);

            $em -> persist($produit);
            $em -> flush();



            return $this -> redirectToRoute('afficherProduitsBack');




        }

        return $this -> render('@Produits/Produits/ajouterProduit.html.twig',
            array('form' => $form -> createView(),'user'=>$user));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/")
     *
     * @Security("has_role('ROLES_ADMIN')")
     */

    public function afficherProduitsBackAction(Request $request)
    {
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            ->findAll();

        $user = $this->getUser();

        $produitsExpire=$this -> getDoctrine()
            -> getRepository(Produits::class)
            ->StatProdExp();

        $produitsNonExpire=$this -> getDoctrine()
            -> getRepository(Produits::class)
            ->StatProdNonExp();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this ->get('knp_paginator');
        $result=$paginator->paginate(
            $produit,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',4)
        );



        return $this -> render('@Produits/Produits/afficherProduitsBack.html.twig', array('produits' => $result,'user' => $user, 'prodExp'=>$produitsExpire,'prodNonExp'=>$produitsNonExpire));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/")
     *
     * @Security("has_role('ROLES_ADMIN')")
     */

    function supprimerProduitAction($ref_p)
    {


        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            -> find($ref_p);
        $widhlist = $this -> getDoctrine()
            -> getRepository(Wishlist::class)
            -> findOneBy(array("refP"=>$ref_p));



        $image=$produit->getImage();
        $path=$this->getParameter('image_directory').'/'.$image;
        $fs=new Filesystem();
        $fs->remove(array($path));
        $em = $this -> getDoctrine() -> getManager();
        $em-> remove($widhlist);
        $em -> remove($produit);
        $em -> flush();

        return $this -> redirectToRoute('afficherProduitsBack');

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/")
     *
     * @Security("has_role('ROLES_ADMIN')")
     */


    function modifierCategorieAction(Request $request, $ref_c)
    {
        $em = $this -> getDoctrine() -> getManager();
        $categorie = $this -> getDoctrine()
            -> getRepository(Categories::class)
            -> find($ref_c);
        $user = $this->getUser();

        $form = $this -> createForm(CategoriesType::class, $categorie);
        $form -> handleRequest($request);
        if ($form -> isSubmitted() && $form -> isValid()) {

            $categorie->setRefC($ref_c);
            $em -> flush();
            return $this -> redirectToRoute('afficherCategories');
        }
        return $this->render('@Produits/Produits/modififerCategorie.html.twig',
            array('form'=>$form->createView(),'user'=>$user));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/")
     *
     * @Security("has_role('ROLES_ADMIN')")
     */

    function modifierProduitAction(Request $request, $ref_p)
    {
        $em = $this -> getDoctrine() -> getManager();
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            -> find($ref_p);
        $user = $this->getUser();

        $form = $this -> createForm(ProduitsModifType::class, $produit);
        $form -> handleRequest($request);

        if ($form -> isSubmitted()) {

            /*------------------------------------------------------------------------------------------------------------*/


            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['image'] -> getData();
            if ($uploadedFile) {
                $destination = $this -> getParameter('image_directory');
                $originalFilename = pathinfo($uploadedFile -> getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $produit -> getImage($originalFilename) . '-' . uniqid() . '.' . $uploadedFile -> guessExtension();
                $uploadedFile -> move(
                    $destination,
                    $newFilename
                );
                $produit -> setImage($newFilename);
            }


            /*------------------------------------------------------------------------------------------------------------*/


            $em -> flush();

            return $this -> redirectToRoute('afficherProduitsBack');
        }

        return $this->render('@Produits/Produits/modifierProduit.html.twig',
            array('form'=>$form->createView(),'user'=>$user));
    }




    /*public function modalContentAction($refP)
    {
        $em = $this -> getDoctrine() -> getManager();
        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            -> find($refP);

        return $this -> render('@Baskel/Produits/modalContent.html.twig', array('produit' => $produit));
    }*/


    /**
     * @Route("/", name="modalContent")
     */
    public function modalContentAction( Request $request ){
        $id = $request->query->get('id');

        return $this -> render('@Produits/Produits/modalContent.html.twig', array('id' => $id));

    }



    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/client/")
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function afficherWishlistsAction( Request $request ){

        $user = $this->getUser()->getId();
        $user2 = $this->getUser()->getUsername();


        $wishlist = $this -> getDoctrine()
            -> getRepository(Wishlist::class)
            -> findBy(array('idClient'=>$user));
        //**************Nour PART *************************//
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        //$session->clear();
        $nbr = count($session->get('panier'));
        if($nbr >= 1 )
            $produits = $em->getRepository('ProduitsBundle:Produits')->findBy(array('ref_p' => array_keys($session->get('panier'))));
        else $produits =array();
        //**************END Nour PART *************************//


        return $this -> render('@Produits/Produits/afficherWishlists.html.twig',array('wishlist'=>$wishlist,'user' => $user2,
            'panier' =>$session->get('panier'),
            'produit1' => $produits));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/client/")
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function ajouterWishlistsAction( Request $request ,$refP){

        $user = $this->getUser()->getId();
        $wishlist = new Wishlist();
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository(Produits::class)->findBy(array('ref_p'=>$refP));

        $emWish = $this -> getDoctrine() -> getManager();
        $wishy = $emWish->getRepository(Wishlist::class)->FindTheWishlist($user,$refP);

        if($wishy == null) {


            foreach ($produits as $p) {

                $em2 = $this -> getDoctrine() -> getManager();

                $wishlist -> setRefP($p);
                $wishlist -> setNomProd($p -> getNomP());
                $wishlist -> setPrixProd($p -> getPrixP());
                $wishlist -> setQteProd($p -> getQuantiteP());
                $wishlist -> setIdClient($this -> getUser());
                $wishlist -> setImageProd($p -> getImage());

                $em2 -> persist($wishlist);
                $em2 -> flush();
                $wishlist = new Wishlist();

                var_dump($wishlist);
            }
        } else {
            return $this -> redirectToRoute('alert',array('user'=>$user));
        }


        return $this -> redirectToRoute('afficherWishlists',array('user'=>$user,'wishlist'=>$wishlist));

    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/")
     *
     * @Security("has_role('ROLES_ADMIN')")
     */

    public function sendMailAction( Request $request){

        $user = $this->getUser();

        $mail=new Mail();
        $form=$this->createForm(MailType::class,$mail);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $subject=$mail->getSubject();
            $bodyPart=$mail->getObjet();
            $mail = $mail->getMail();
            $object=$request->get('f')['objet'];
            $usename='ashlynx1997@gmail.com';
            $message=\Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($usename)
                ->setTo($mail)
                ->addPart($bodyPart)
                ->setBody($object);
            $this->get('mailer')->send($message);
            $this->get('session')->getFlashBag()->add('notice','Message envoyé avec success');
        }
        return $this->render('@Produits/Produits/sendMail.html.twig',array('f'=>$form->createView(),'user'=>$user));
    }



    function supprimerWishlistAction($id)
    {
        $em = $this -> getDoctrine() -> getManager();


        $wishlist = $this -> getDoctrine()
            -> getRepository(Wishlist::class)
            -> find($id);
        //var_dump($wishlist);
            $em -> remove($wishlist);
            $em -> flush();



        return $this -> redirectToRoute('afficherWishlists');
    }

    function insertRatingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $id=$request->get('ref');
        $rating=$request->get('rating');

        $em->getRepository(Produits::class)->UpdateRating($id,$rating);
        $msg="saye";
        return new Response(json_encode(array( 'msg'=>$msg)));

    }

    function FetchRatingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $rating=$em->getRepository(Produits::class)->fetchRating();
       $nbr=count($rating);
        return new Response(json_encode(array( 'rating'=>$rating,'nbr'=>$nbr)));

    }



    public function soldeEditAction($ref_p, Request $request){

        $em = $this -> getDoctrine() -> getManager();

        $produit = $this -> getDoctrine()
            -> getRepository(Produits::class)
            -> find($ref_p);

        //   var_dump($produit);

        $user = $this->getUser();

        $form = $this -> createForm(ModifierSoldeType::class, $produit);
        $form -> handleRequest($request);

        $newSolde=$form->get('solde')->getData();
        $produit->setSolde($newSolde);


        $solde = ($produit -> getPrixP() * $newSolde) / 100;




        if ($solde < $produit -> getPrixP()) {

            $newPrice = $produit -> getPrixP() - $solde;

            $produit -> setPrixP($newPrice);
        } else {
            $produit -> setPrixP($produit -> getPrixP());
        }
        $em -> persist($produit);
        $em -> flush();


        return $this->render('@Produits/Produits/modifierSolde.html.twig',
            array('form'=>$form->createView(),'user'=>$user));

    }




}
