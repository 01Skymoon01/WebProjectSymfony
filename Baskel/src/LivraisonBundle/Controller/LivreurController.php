<?php
/**
 * Created by PhpStorm.
 * Livreur: Achraf Zaafrane
 * Date: 2/10/2020
 * Time: 2:17 AM
 */

namespace LivraisonBundle\Controller;
use LivraisonBundle\Entity\livraison;
use LivraisonBundle\Entity\Livreur;
use LivraisonBundle\Entity\Vehicule;
use LivraisonBundle\Form\LivreurType;
use LivraisonBundle\Form\modifEtatType;
use LivraisonBundle\Form\ModifiSoldeType;
use LivraisonBundle\Form\RegistrationFormType;
use LivraisonBundle\Form\VehiculeType;
use PanierBundle\Entity\Commande;
use PanierBundle\Entity\DetailsCommande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class LivreurController extends  Controller
{

    public function registerLivreurAction(Request $request)
    {

        $livreur = new Livreur();
        $form = $this->createForm(LivreurType::class, $livreur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $usr = $this->get('security.token_storage')->getToken()->getUser();

            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser()->getId();
            $em = $this->getDoctrine()->getManager();
            $livreurExist = $em->getRepository(Livreur::class)->findOneBy(array("id_username"=>$usr));
           var_dump(count($livreurExist));

           if(count($livreurExist) == 0) {
               $livreur->setIdUsername($usr);
               $entityManager->persist($livreur);
               $entityManager->flush();


               $userManager = $this->get('fos_user.user_manager');
               // Use findUserby, findUserByUsername() findUserByEmail() findUserByUsernameOrEmail, findUserByConfirmationToken($token) or findUsers()
               $user = $userManager->findUserBy(array('id' => $user));


               // Add the role that you want !
               $user->addRole("ROLE_LIVREUR");
               // Update user roles
               $userManager->updateUser($user);
               $this->addFlash("success"," success !");

           }else {
               $this->addFlash("error"," error !");
           }
            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            '@Livraison/Livreur/register_content.html.twig',
            ['form' => $form->createView()]
        );
    }
    public  function  afficheLivreurAction(){
        $livreurs=$this->getDoctrine()->getRepository(Livreur::class)->findAll();

        $vehicules=$this->getDoctrine()->getRepository(Vehicule::class)->findAll();
        return $this->render('@Livraison/Livreur/consliv.html.twig',array('vehicules'=>$vehicules,'livreurs'=>$livreurs));
    }

    public  function  modifEtatAction($id,Request $request){

        $em= $this->getDoctrine()->getManager();
        $livreur=$em->getRepository(Livreur::class)->find($id);
        $form=$this->createForm(modifEtatType::class,$livreur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($livreur);
            $em->flush();
            //MAIL
            if($livreur->getEtat()=="accepté") {


                $message = (new \Swift_Message('Hello Email'))
                    ->setFrom('achraf9585@gmail.com')
                    ->setTo($livreur->getEmail())
                    ->setBody(
                        $this->renderView(
                        // templates/emails/registration.html.twig
                            'BaskelBundle:Livreur:mail.txt.twig'

                ),
                        'text/html'
                    )// you can remove the following code if you don't define a text version for your emails

                ;

                $this->get('mailer')->send($message);            }

            return $this->redirectToRoute('consliv');
        }
        return $this->render('@Livraison/Livreur/modifetat.html.twig',array('form'=>$form->createView(),'livreur'=>$livreur));
    }

    public  function  modifSoldeAction($id,Request $request){
        $em= $this->getDoctrine()->getManager();
        $livreur=$em->getRepository(Livreur::class)->find($id);
        $form=$this->createForm(ModifiSoldeType::class,$livreur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($livreur);
            $em->flush();
            return $this->redirectToRoute('consliv');
        }
        return $this->render('@Livraison/Livreur/modifisolde.html.twig',array('form'=>$form->createView(),'livreur'=>$livreur));
    }
    public function pdfAction($id,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(Livreur::class)->find($id);
        $vehicule=$em->getRepository(Vehicule::class)->findBy(array('user'=>$id));
        $snappy=$this->get('knp_snappy.pdf');
        $html = $this -> renderView("@Baskel/Livreur/pdf.html.twig", array(
                'user'=>$user,
                'vehicule'=>$vehicule,
                'rootDir' => $this->get('kernel')->getRootDir().'/..'
            )
        );
        $filename="fichel";
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition'=> 'attachment ; filename="' .$filename.'.pdf"'
            )
        );

    }

    public  function  afficheCommandeNonLivreeAction(Request $request){
        $commande=$this->getDoctrine()->getRepository(Commande::class)->findBy(array("etatLiv"=>0));

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this ->get('knp_paginator');
        $result=$paginator->paginate(
            $commande,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',4)
        );
        return $this->render('@Livraison/Livreur/commandeNonLivree.html.twig',array('c'=>$result));
    }
    public function ModifierEtatCommandeLivreeAction(Request $request , $id,$etat){

        $em= $this->getDoctrine()->getManager();
        $this->getDoctrine()
            ->getRepository(Commande::class)
            ->ModifierEtatLivraison($id,1);
        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $livreurExist = $em->getRepository(Livreur::class)->findOneBy(array("id_username"=>$usr));


        $commande=$this->getDoctrine()->getRepository(Commande::class)->findBy(array("etatLiv"=>0));

        $commandeALivree=$this->getDoctrine()->getRepository(Commande::class)->findOneBy(array("id"=>$id));


        $Livraison = new livraison();
        $Livraison->setIdCommande($commandeALivree);
        $Livraison->setIdLivreur($livreurExist);


        $em->persist($Livraison);
        $em->flush();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this ->get('knp_paginator');
        $result=$paginator->paginate(
            $commande,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',4)
        );
        return $this->render('@Livraison/Livreur/commandeNonLivree.html.twig',array('c'=>$result));
    }
}