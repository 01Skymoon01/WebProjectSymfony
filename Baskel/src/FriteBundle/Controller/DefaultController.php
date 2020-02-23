<?php

namespace FriteBundle\Controller;

use FriteBundle\Entity\Mail;
use FriteBundle\Entity\RDV;
use FriteBundle\Entity\Reclamation;
use FriteBundle\Entity\Technicien;
use FriteBundle\Form\AffecterTechType;
use FriteBundle\Form\MailType;
use FriteBundle\Form\RDV1Type;
use FriteBundle\Form\RDVType;
use FriteBundle\Form\Reclamation1Type;
use FriteBundle\Form\ReclamationType;
use FriteBundle\Form\Technicien1Type;
use FriteBundle\Form\TechnicienType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FriteBundle:Default:index.html.twig');
    }
    public function indexAdminAction()
    {
        return $this->render('@Frite/Default/indexadmin.html.twig');
    }

    /************************************************** CRUD RECLAMATION**********************************************************************/

    public function AjouterReclamationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $Reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash("success","Reclamation cree avec succes");
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $user->getId();
            $Reclamation->setEtatR('non traitee');
            $Reclamation->setUserid($user);
            $em->persist($Reclamation);
            $em->flush();
            return $this->redirectToRoute('DisplayReclamation');
        }
        return $this->render('@Frite/FRITE/reclamation.html.twig', array('form' => $form->createView()));
    }

    public function AfficherReclamationsAction()
    {

        $reclamations = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        $Pnc=$this->getDoctrine()->getRepository(Reclamation::class)->SelectRecNC();
        $Pa=$this->getDoctrine()->getRepository(Reclamation::class)->SelectRecAb();
        $Lnr=$this->getDoctrine()->getRepository(Reclamation::class)->SelectLivNR();
        $Lnc=$this->getDoctrine()->getRepository(Reclamation::class)->SelectLivNC();
        $Fact=$this->getDoctrine()->getRepository(Reclamation::class)->SelectFact();
        $Aut=$this->getDoctrine()->getRepository(Reclamation::class)->SelectAutre();

        return $this->render('@Frite/FRITE/reclamationBack.html.twig', array('reclamations' => $reclamations , 'nonconf'=>$Pnc,
            'abime'=>$Pa, 'lnr'=>$Lnr, 'lnc'=>$Lnc, 'fact'=>$Fact, 'Aut'=>$Aut));
    }

    public function SupprimerReclamationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("AfficherReclamations");

    }

    public function DeleteReclamationAction($id, Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            $reclamation = $em->getRepository(Reclamation::class)->find($id);
            $em->remove($reclamation);
            $em->flush();
            return new JsonResponse('good');
        }
    }

    public function DisplayReclamationAction()
    {
        $usr = $this->get('security.token_storage')->getToken()->getUser();
        // $reclamations=$reclamationRepository->findby( a);
        $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->findBy(array('userid' => $usr));
        return $this->render('@Frite/FRITE/listRec.html.twig', array('reclamations' => $reclamations));
    }

    public function ModifierReclamationAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);
        $form = $this->createForm(Reclamation1Type::class, $reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash("success","Reclamation modifie avec succes");
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('DisplayReclamation');
        }
        return $this->render('@Frite/FRITE/reclamationModif.html.twig', array('form' => $form->createView()));

    }

    public function TraiterReclamationAction($id,Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $variable=$em->getRepository(Reclamation::class)->find($id);
        $variable->setEtatR('traitee');
        $mm=$variable->getUserid()->getEmail();
        $html = $this -> renderView("@Frite/FRITE/pdf1.html.twig", array('rec'=>$variable));
        $filename="friiiiiteuuu";
        $pdf = $this->get("knp_snappy.pdf")->getOutputFromHtml($html);

        $usename='ashlynx1997@gmail.com';
            $message=\Swift_Message::newInstance()
                -> setSubject('Traitement de Votre Reclamation')
                -> setFrom($usename)
                -> setTo($mm)
                -> setBody('Nous nous informons que votre Reclamation a ete Traitee. Voici les details:',
                    'text/html');

        $attachement = \Swift_Attachment::newInstance($pdf, $filename, 'application/pdf' );
        $message->attach($attachement);
        $this->get('mailer')->send($message);
        $em->persist($variable);
        $em->flush();


        return $this->redirectToRoute('AfficherReclamations');
    }

    public function pdfRecAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $r=$em->getRepository(Reclamation::class)->find($id);
        $snappy=$this->get('knp_snappy.pdf');
        $html = $this -> renderView("@Frite/FRITE/pdf1.html.twig", array(
                'rec'=>$r
            )
        );
        $filename="friiiiiteuuu";
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition'=> 'attachment ; filename="' .$filename.'.pdf"'
            )
        );

    }


    /**************************************************END CRUD RECLAMATION**********************************************************************/

    /************************************************** CRUD RDV********************************************************************************/

    public function AjouterRDVAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $rdv = new RDV();
        $form=$this->createForm(RDVType::class,$rdv);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->addFlash("success","Rendez-vous cree avec succes");
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $user->getId();
            $rdv->setUserid($user);
            $rdv->setEtatRDV('non traitee');
            $em->persist($rdv);
            $em->flush();
            return $this->redirectToRoute('DisplayRdv');
        }
        return $this->render('@Frite/FRITE/rdv.html.twig',array('form'=>$form->createView()));
    }

    public function AfficherRDVAction()
    {
        $rdv= $this->getDoctrine()->getManager()->getRepository(RDV::class)->findAll();
        $rep=$this->getDoctrine()->getRepository(RDV::class)->Rep();
        $MT=$this->getDoctrine()->getRepository(RDV::class)->MaintTech();
        $RDVT=$this->getDoctrine()->getRepository(RDV::class)->RDVTech();
        $PF=$this->getDoctrine()->getRepository(RDV::class)->ProbFact();
        $Aut=$this->getDoctrine()->getRepository(RDV::class)->SelectAutre();


        return $this->render('@Frite/FRITE/rdvBACK.html.twig',array('rdv'=>$rdv, 'rep'=>$rep,
            'MT'=>$MT, 'RDVT'=>$RDVT, 'PF'=>$PF, 'Aut'=>$Aut ));
    }

    public function SupprimerRDVAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $rdv=$em->getRepository(RDV::class)->find($id);
        $em->remove($rdv);
        $em->flush();
        $this->addFlash("success","Rendez-vous supprime avec succes");
        return $this->redirectToRoute("AfficherRDV");
    }

    public function DeleteRDVAction($id, Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            $rdv = $em->getRepository(RDV::class)->find($id);
            $em->remove($rdv);
            $em->flush();
            return new JsonResponse('good');
        }
    }

    public function DisplayRdvAction ()
    {
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $rdv=$this->getDoctrine()->getRepository(RDV::class)->findBy(array('userid'=> $usr));
        return $this->render('@Frite/FRITE/listRDV.html.twig',array('rdv'=>$rdv));
    }

    public function ModifierRDVAction($id,Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $rdv=$em->getRepository(RDV::class)->find($id);
        $form=$this->createForm(RDV1Type::class,$rdv);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->addFlash("success","Rendez-vous modifie avec succes");
            $em->persist($rdv);
            $em->flush();
            return $this->redirectToRoute('DisplayRdv');
        }
        return $this->render('@Frite/FRITE/rdvModif.html.twig',array('form'=>$form->createView()));
    }

    public function AcceptRDVAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $variable=$em->getRepository(RDV::class)->find($id);
        $variable->setEtatRDV('Accepte');
        $mm=$variable->getUserid()->getEmail();
        $html = $this -> renderView("@Frite/FRITE/pdf.html.twig", array('rdv'=>$variable));
        $filename="friiiiiteuuu";
        $pdf = $this->get("knp_snappy.pdf")->getOutputFromHtml($html);
        $message = \Swift_Message::newInstance()
            -> setSubject('Rendez-vous Acceptee')
            -> setFrom('gintokiismyhusband@gmail.com')
            -> setTo($mm)
            -> setBody('Nous nous informons que votre Rendez-vous a ete accepte. Voici les details:',
                'text/html');

        $attachement = \Swift_Attachment::newInstance($pdf, $filename, 'application/pdf' );
        $message->attach($attachement);
        $this->get('mailer')->send($message);

        $em->persist($variable);
        $em->flush();
        return $this->redirectToRoute('AfficherRDV' );
    }


    public function RefusRDVAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $variable=$em->getRepository(RDV::class)->find($id);
        $variable->setEtatRDV('Refuse');
        $mm=$variable->getUserid()->getEmail();


        $html = $this -> renderView("@Frite/FRITE/pdf.html.twig", array('rdv'=>$variable));
        $filename="friiiiiteuuu";
        $pdf = $this->get("knp_snappy.pdf")->getOutputFromHtml($html);
        //  $body = $this->redirectToRoute('pdf');

        $message = \Swift_Message::newInstance()
            -> setSubject('Rendez-vous refuse')
            -> setFrom('gintokiismyhusband@gmail.com')
            -> setTo($mm)
            -> setBody('Nous nous excusons de vous informer que votre Rendez-vous a ete refuse. Voici les details',
                'text/html');


        $attachement = \Swift_Attachment::newInstance($pdf, $filename, 'application/pdf' );
        $message->attach($attachement);
        $this->get('mailer')->send($message);

        $em->persist($variable);
        $em->flush();
        return $this->redirectToRoute('AfficherRDV');
    }



    public function pdfAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $rdv=$em->getRepository(RDV::class)->find($id);
        $snappy=$this->get('knp_snappy.pdf');
        $html = $this -> renderView("@Frite/FRITE/pdf.html.twig", array(
                'rdv'=>$rdv
            )
        );
        $filename="friiiiiteuuu";
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition'=> 'attachment ; filename="' .$filename.'.pdf"'
            )
        );

    }


    public function AffecterTechnicienAction($id,Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $rdv=$em->getRepository(RDV::class)->find($id);
        $form=$this->createForm(AffecterTechType::class,$rdv);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->addFlash("success","Technicien affecte avec succes");
            $em->persist($rdv);
            $em->flush();
            return $this->redirectToRoute('AfficherRDV');
        }
        return $this->render('@Frite/FRITE/affecterTech.html.twig',array('form'=>$form->createView(), 'RDV'=>$rdv));
    }


    /**************************************************END CRUD RDV**********************************************************************/

    /**************************************************CRUD TECHNICIEN**********************************************************************/
    public function AjouterTechnicienAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $technicien = new Technicien();
        $form=$this->createForm(TechnicienType::class,$technicien);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->addFlash("success","Technicien ajoute avec succes");
            $em->persist($technicien);
            $em->flush();
            return $this->redirectToRoute('AfficherTechniciens');
        }
        return $this->render('@Frite/FRITE/ajoutertechnicien.html.twig',array('form'=>$form->createView()));
    }

    public function AfficherTechniciensAction()
    {
        $technicien= $this->getDoctrine()->getManager()->getRepository(Technicien::class)->findAll();
        return $this->render('@Frite/FRITE/technicienBACK.html.twig',array('techniciens'=>$technicien));
    }

    public function SupprimerTechnicienAction($id, Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            $technicien = $em->getRepository(Technicien::class)->find($id);
            $em->remove($technicien);
            $em->flush();
            $this->addFlash("success", "Technicien supprime avec succes");
            return new JsonResponse('good');
        }
    }

    public function ModifierTechnicienAction($id,Request $request)

    {
        $em= $this->getDoctrine()->getManager();
        $technicien=$em->getRepository(Technicien::class)->find($id);
        $form=$this->createForm(Technicien1Type::class,$technicien);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->addFlash("success","Technicien modifie avec succes");
            $em->persist($technicien);
            $em->flush();
            return $this->redirectToRoute('AfficherTechniciens');
        }
        return $this->render('@Frite/FRITE/modifiertechnicien.html.twig',array('form'=>$form->createView()));

    }

    /**************************************************END CRUD TECHNICIEN**********************************************************************/

    /****************************************************SEND MAIL********************************************************************************/

    public function sendMailAction(Request $request)
    {
        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $subject = $mail->getSubject();
            $mail = $mail->getMail();
            $objet = $request->get('form')['objet'];
            $username ='gintokiismyhusband@gmail.com';
            $message = \Swift_Message::newInstance()
                ->setSubject($objet)
                ->setFrom($username)
                ->setTo($mail)
                ->setBody($subject);
            $this->get('mailer')->send($message);

        }
        return $this->render('@Frite/FRITE/Mail.html.twig', array('f' => $form->createView()));
    }


    public function calendarAction()
    {
        return $this->render('@Frite/FRITE/calendar.html.twig');
    }


}


