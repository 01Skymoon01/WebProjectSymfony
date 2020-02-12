<?php


namespace BaskelBundle\Controller;


use AppBundle\Entity\Vehicule;
use AppBundle\Form\VehiculeType;
use BaskelBundle\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class VehiculeController extends AbstractController
{
    public function indexAction()
    {

        return $this->render('@Baskel/Default/index.html.twig');
    }
    public  function  afficheVehiculeAction(){
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $vehicules=$this->getDoctrine()->getRepository(Vehicule::class)->findAll();
        return $this->render('@Baskel/Vehicule/index.html.twig',array('vehicules'=>$vehicules));
    }
    public function ajoutAction(Request $request)
    {
        $usr= $this->get('security.token_storage')->getToken()->getUser();

        $vehicule= new Vehicule();
        $form=$this->createForm(VehiculeType::class,$vehicule);
        $form->handleRequest($request);
        $em=$this->getDoctrine()->getManager();
        if($form->isSubmitted()){
            $vehicule->setUser($usr);
            $em->persist($vehicule);
            $em->flush();
            return $this->redirectToRoute('affvehicule');
        }

        return $this->render('@Baskel/Vehicule/ajout.html.twig',array('form'=>$form->createView()));
    }

    public function supprimerAction($id){
        $em = $this->getDoctrine()->getManager();
        $vehicule = $em->getRepository(Vehicule::class)->find($id);
        $em->remove($vehicule);
        $em->flush();
        return $this->redirectToRoute('affvehicule');
    }
    public function modifierAction($id,Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $rdv=$em->getRepository(Vehicule::class)->find($id);
        $form=$this->createForm(VehiculeType::class,$rdv);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($rdv);
            $em->flush();
            return $this->redirectToRoute('affvehicule');
        }
        return $this->render('@Baskel/Vehicule/edit.html.twig',array('form'=>$form->createView()));
    }
}