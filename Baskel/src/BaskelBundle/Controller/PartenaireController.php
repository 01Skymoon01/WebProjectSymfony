<?php

namespace BaskelBundle\Controller;

use BaskelBundle\Entity\Partenaire;
use BaskelBundle\Form\PartenaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PartenaireController extends Controller
{
    public function AjoutPartenaireAction(Request $request)
    {
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted()) {
            $em->persist($partenaire);
            $em->flush();
            return $this->redirectToRoute('AfficheP');
        }
        return $this->render('@Baskel/Default/AjoutPartenaire.html.twig', array('f' => $form->createView()));
    }

    public function AffichePartenaireAction()
    {
        $partenaires = $this->getDoctrine()->getRepository(Partenaire::class)->findAll();
        return $this->render('@Baskel/Default/affichePartenaire.html.twig', array(
            "partenaires" => $partenaires
        ));
    }

    function SupprimerPartenaireAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $partenaire = $this->getDoctrine()->getRepository(Partenaire::class)
            ->find($id);
        $em->remove($partenaire);
        $em->flush();
        return $this->redirectToRoute('AfficheP');

    }

    public function ModifierPartenaireAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $partenaire = $this->getDoctrine()
            ->getRepository(Partenaire::class)
            ->find($id);
        $Form = $this->createForm(PartenaireType::class, $partenaire);
        $Form->handleRequest($request);
        if ($Form->isSubmitted()) {
            $em->flush();
            return $this->redirectToRoute('AfficheP');

        }
        return $this->render('@Baskel/Default/UpdatePartenaire.html.twig',
            array('f' => $Form->createView()));

    }

}
