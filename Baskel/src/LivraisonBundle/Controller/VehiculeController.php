<?php


namespace LivraisonBundle\Controller;


use LivraisonBundle\Entity\Livreur;
use LivraisonBundle\Entity\Vehicule;
use LivraisonBundle\Form\VehiculeType;
use LivraisonBundle\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class VehiculeController extends AbstractController
{
    public function indexAction()
    {

        return $this->render('@Livraison/Default/index.html.twig');
    }
    public  function  afficheVehiculeAction(){
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $em=$this->getDoctrine()->getManager();
        $livreur=$em->getRepository(Livreur::class)->findOneBy(array("id_username"=>$usr));
        $vehicules=$this->getDoctrine()->getRepository(Vehicule::class)->findBy(array('user'=>$livreur));
        return $this->render('@Livraison/Vehicule/index.html.twig',array('vehicules'=>$vehicules));
    }
    public function ajoutAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $livreur=$em->getRepository(Livreur::class)->findOneBy(array("id_username"=>$usr));

        $vehicule= new Vehicule();
        $form=$this->createForm(VehiculeType::class,$vehicule);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $vehicule->setUser($livreur);
            $em->persist($vehicule);
            $em->flush();
            return $this->redirectToRoute('affvehicule');
        }

        return $this->render('@Livraison/Vehicule/ajout.html.twig',array('form'=>$form->createView()));
    }

    public function supprimerAction($id,Request $request)
    {
        if($request->isXmlHttpRequest()){
            $id = $request->get('id');

            $em = $this->getDoctrine()->getManager();
            $vehicule = $em->getRepository(Vehicule::class)->find($id);
            $em->remove($vehicule);
            $em->flush();
            return new JsonResponse('good');
        }


    }
        /*
    public function supprimerAction($id){
        $em = $this->getDoctrine()->getManager();
        $vehicule = $em->getRepository(Vehicule::class)->find($id);
        $em->remove($vehicule);
        $em->flush();
        return $this->redirectToRoute('affvehicule');
    }
  */
    public function modifierAction($id,Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $voiture=$em->getRepository(Vehicule::class)->find($id);
        $form=$this->createForm(VehiculeType::class,$voiture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('affvehicule');
        }
        return $this->render('@Livraison/Vehicule/edit.html.twig',array('form'=>$form->createView()));
    }


}