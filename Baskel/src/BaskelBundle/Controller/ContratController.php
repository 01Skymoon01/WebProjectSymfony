<?php

namespace BaskelBundle\Controller;

use BaskelBundle\Form\ContratType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContratController extends Controller
{
    public function SignerContratAction(Request $request)
    {
        $contrat = new Contrat();
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted()) {
            $em->persist($contrat);
            $em->flush();
            return $this->redirectToRoute('AfficheC');
        }
        return $this->render('@Baskel/Default/SignerContrat.html.twig', array('f' => $form->createView()));
    }
}
