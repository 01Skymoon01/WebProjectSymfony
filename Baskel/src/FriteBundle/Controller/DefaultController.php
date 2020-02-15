<?php

namespace FriteBundle\Controller;

use FriteBundle\Entity\RDV;
use FriteBundle\Entity\Reclamation;
use FriteBundle\Entity\Technicien;
use FriteBundle\Form\RDV1Type;
use FriteBundle\Form\RDVType;
use FriteBundle\Form\Reclamation1Type;
use FriteBundle\Form\ReclamationType;
use FriteBundle\Form\Technicien1Type;
use FriteBundle\Form\TechnicienType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        return $this->render('@Frite/FRITE/reclamationBack.html.twig', array('reclamations' => $reclamations));
    }

    public function SupprimerReclamationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("AfficherReclamations");

    }

    public function DeleteReclamationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);

        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("DisplayReclamation");
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
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('DisplayReclamation');
        }
        return $this->render('@Frite/FRITE/reclamationModif.html.twig', array('form' => $form->createView()));

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
        return $this->render('@Frite/FRITE/rdvBACK.html.twig',array('rdv'=>$rdv));
    }

    public function SupprimerRDVAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $rdv=$em->getRepository(RDV::class)->find($id);
        $em->remove($rdv);
        $em->flush();
        return $this->redirectToRoute("AfficherRDV");
    }

    public function DeleteRDVAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $rdv=$em->getRepository(RDV::class)->find($id);
        $em->remove($rdv);
        $em->flush();
        return $this->redirectToRoute("DisplayRdv");
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
            $em->persist($rdv);
            $em->flush();
            return $this->redirectToRoute('DisplayRdv');
        }
        return $this->render('@Frite/FRITE/rdvModif.html.twig',array('form'=>$form->createView()));
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

    public function SupprimerTechnicienAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $technicien=$em->getRepository(Technicien::class)->find($id);
        $em->remove($technicien);
        $em->flush();
        return $this->redirectToRoute("AfficherTechniciens");
    }

    public function ModifierTechnicienAction($id,Request $request)

    {
        $em= $this->getDoctrine()->getManager();
        $technicien=$em->getRepository(Technicien::class)->find($id);
        $form=$this->createForm(Technicien1Type::class,$technicien);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($technicien);
            $em->flush();
            return $this->redirectToRoute('AfficherTechniciens');
        }
        return $this->render('@Frite/FRITE/modifiertechnicien.html.twig',array('form'=>$form->createView()));

    }

    /**************************************************END CRUD TECHNICIEN**********************************************************************/





}


