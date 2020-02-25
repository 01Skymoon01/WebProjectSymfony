<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Contrat;
use EventBundle\Entity\Partenaire;
use EventBundle\Form\ContratType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContratController extends Controller
{
    public function SignerContratAction(Request $request,$id)
    {
        $contrat = new Contrat();

        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        $partenaire=$em->getRepository(Partenaire::class)->find($id);
        if ($form->isSubmitted()) {
            $em->persist($contrat);
            $contrat->setIdPartenaire($partenaire);
            $em->flush();
            return $this->redirectToRoute('AfficheC');
        }
        return $this->render('@Event/Default/SignerContrat.html.twig', array('f' => $form->createView()));
    }

    public function AfficheContratAction()
    {
        $contrats = $this->getDoctrine()->getRepository(Contrat::class)->findAll();
        return $this->render('@Event/Default/afficheContrat.html.twig', array(
            "contrats" => $contrats
        ));
    }

    public function SupprimerContratAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $contrat = $this->getDoctrine()->getRepository(Contrat::class)
            ->find($id);
        $em->remove($contrat);
        $em->flush();
        return $this->redirectToRoute('AfficheC');

    }

    public function pdfAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $c = $em->getRepository(Contrat::class)->find($id);
        $snappy = $this->get('knp_snappy.pdf');
        $html = $this->renderView("@Event/Default/pdf.html.twig", array(
                'contrat' => $c
            )
        );
        $filename = "Contrat";
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment ; filename="' . $filename . '.pdf"'
            )
        );

    }

}
