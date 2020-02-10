<?php

namespace BaskelBundle\Controller;

use BaskelBundle\Entity\RDV;
use BaskelBundle\Entity\Reclamation;
use BaskelBundle\Entity\Technicien;
use BaskelBundle\Form\RDVType;
use BaskelBundle\Form\ReclamationType;
use BaskelBundle\Form\TechnicienType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Baskel/Default/index.html.twig');
    }
    public function indexAdminAction()
    {
        return $this->render('@Baskel/Default/indexadmin.html.twig');
    }
    /*
    public function rdvAction()
    {
        return $this->render('@Baskel/FRITE/rdv.html.twig');
    }
    public function reclamationAction()
    {
        return $this->render('@Baskel/FRITE/reclamation.html.twig');
    }*/


    /**************************************************END CRUD RECLAMATION**********************************************************************/

    public function AjouterReclamationAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $Reclamation = new Reclamation();
        $form=$this->createForm(ReclamationType::class,$Reclamation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $user->getId();
            $Reclamation->setEtatR('non traitee');
            $Reclamation->setUserid($user);
            $em->persist($Reclamation);
            $em->flush();
            return $this->redirectToRoute('reclamation');
        }
        return $this->render('@Baskel/FRITE/reclamation.html.twig',array('form'=>$form->createView()));
    }

    public function AfficherReclamationsAction()
    {
        $reclamations= $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        return $this->render('@Baskel/FRITE/reclamationBack.html.twig',array('reclamations'=>$reclamations));
    }

   public function SupprimerReclamationAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("AfficherReclamations");
    }

   /* public function ModifierReclamationAction($id,Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        $form=$this->createForm(Amende1Type::class,$amende);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($amende);
            $em->flush();
            return $this->redirectToRoute('AfficherAmendes');
        }
        return $this->render('@Amends/Default/AjouterAmende.html.twig',array('form'=>$form->createView()));
    }*/

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
            return $this->redirectToRoute('rdv');
        }
        return $this->render('@Baskel/FRITE/rdv.html.twig',array('form'=>$form->createView()));
    }

    public function AfficherRDVAction()
    {
        $rdv= $this->getDoctrine()->getManager()->getRepository(RDV::class)->findAll();
        return $this->render('@Baskel/FRITE/rdvBACK.html.twig',array('rdv'=>$rdv));
    }

    public function SupprimerRDVAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $rdv=$em->getRepository(RDV::class)->find($id);
        $em->remove($rdv);
        $em->flush();
        return $this->redirectToRoute("AfficherRDV");
    }


    /* public function ModifierReclamationAction($id,Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        $form=$this->createForm(Amende1Type::class,$amende);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($amende);
            $em->flush();
            return $this->redirectToRoute('AfficherAmendes');
        }
        return $this->render('@Amends/Default/AjouterAmende.html.twig',array('form'=>$form->createView()));
    }*/
    /**************************************************END CRUD RECLAMATION**********************************************************************/


    /**************************************************CRUD TECHNICIEN**********************************************************************/
  /*  public function AjouterTechnicienAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $technicien = new Technicien();
        $form=$this->createForm(TechnicienType::class,$technicien);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($technicien);
            $em->flush();
            //return $this->redirectToRoute('');
        }
        return $this->render('@Baskel/FRITE/technicienBACK.html.twig',array('form'=>$form->createView()));
    }*/

    public function AfficherTechniciensAction()
    {
        $technicien= $this->getDoctrine()->getManager()->getRepository(Technicien::class)->findAll();
        return $this->render('@Baskel/FRITE/technicienBACK.html.twig',array('techniciens'=>$technicien));
    }

    public function SupprimerTechnicienAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $technicien=$em->getRepository(Technicien::class)->find($id);
        $em->remove($technicien);
        $em->flush();
        return $this->redirectToRoute("AfficherTechniciens");
    }

    /* public function ModifierReclamationAction($id,Request $request)
{
    $em= $this->getDoctrine()->getManager();
    $reclamation=$em->getRepository(Reclamation::class)->find($id);
    $form=$this->createForm(Amende1Type::class,$amende);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid())
    {
        $em->persist($amende);
        $em->flush();
        return $this->redirectToRoute('AfficherAmendes');
    }
    return $this->render('@Amends/Default/AjouterAmende.html.twig',array('form'=>$form->createView()));
}*/

    /**************************************************END CRUD TECHNICIEN**********************************************************************/



}
