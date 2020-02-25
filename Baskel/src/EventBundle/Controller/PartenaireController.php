<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Partenaire;
use EventBundle\Form\Partenaire3Type;
use EventBundle\Form\PartenaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            $this->addFlash("success","You have added a partner successfully !");
            return $this->redirectToRoute('AfficheP');
        }
        return $this->render('@Event/Default/AjoutPartenaire.html.twig', array('f' => $form->createView()));
    }

    public function AffichePartenaireAction()
    {
        $partenaires = $this->getDoctrine()->getRepository(Partenaire::class)->findAll();
        return $this->render('@Event/Default/affichePartenaire.html.twig', array(
            "partenaires" => $partenaires
        ));
    }

    function SupprimerPartenaireAction($id,Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            $partenaire = $this->getDoctrine()->getRepository(Partenaire::class)
                ->find($id);
            $em->remove($partenaire);
            $em->flush();
            return new JsonResponse('good');

        }

    }

    public function ModifierPartenaireAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $partenaire = $this->getDoctrine()
            ->getRepository(Partenaire::class)
            ->find($id);
        $Form = $this->createForm(Partenaire3Type::class, $partenaire);
        $Form->handleRequest($request);
        if ($Form->isSubmitted()) {
            $em->flush();
            return $this->redirectToRoute('AfficheP');

        }
        return $this->render('@Event/Default/UpdatePartenaire.html.twig',
            array('f' => $Form->createView()));

    }

}
