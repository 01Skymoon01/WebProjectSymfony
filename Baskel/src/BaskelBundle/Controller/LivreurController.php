<?php
/**
 * Created by PhpStorm.
 * User: Achraf Zaafrane
 * Date: 2/10/2020
 * Time: 2:17 AM
 */

namespace BaskelBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Entity\Vehicule;
use AppBundle\Form\modifEtatType;
use AppBundle\Form\ModifiSoldeType;
use AppBundle\Form\VehiculeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class LivreurController extends  Controller
{
    public  function  afficheLivreurAction(){
        $livreurs=$this->getDoctrine()->getRepository(User::class)->findAll();

        $vehicules=$this->getDoctrine()->getRepository(Vehicule::class)->findAll();
        return $this->render('@Baskel/Livreur/consliv.html.twig',array('vehicules'=>$vehicules,'livreurs'=>$livreurs));
    }

    public  function  modifEtatAction($id,Request $request){

        $em= $this->getDoctrine()->getManager();
        $livreur=$em->getRepository(User::class)->find($id);
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
        return $this->render('@Baskel/Livreur/modifetat.html.twig',array('form'=>$form->createView(),'livreur'=>$livreur));
    }

    public  function  modifSoldeAction($id,Request $request){
        $em= $this->getDoctrine()->getManager();
        $livreur=$em->getRepository(User::class)->find($id);
        $form=$this->createForm(ModifiSoldeType::class,$livreur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($livreur);
            $em->flush();
            return $this->redirectToRoute('consliv');
        }
        return $this->render('@Baskel/Livreur/modifisolde.html.twig',array('form'=>$form->createView(),'livreur'=>$livreur));
    }
    public function pdfAction($id,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($id);
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
}