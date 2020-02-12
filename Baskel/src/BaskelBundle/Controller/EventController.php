<?php

namespace BaskelBundle\Controller;

use BaskelBundle\Entity\Event;
use BaskelBundle\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    public function AjoutEventAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted()) {
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('AfficheEv');
        }
        return $this->render('@Baskel/Default/NOCSSAjoutEvent.html.twig', array('f' => $form->createView()));
    }

    public function AfficheEventAction()
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findAll();
        return $this->render('@Baskel/Default/afficheEvents.html.twig', array(
            "events" => $events
        ));
    }
    public function AfficheEventFrontAction()
{
    $events = $this->getDoctrine()->getRepository(Event::class)->findAll();
    return $this->render('@Baskel/Default/afficheEventsfront.html.twig', array(
        "events" => $events
    ));
}


    function SupprimerEventAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $this->getDoctrine()->getRepository(Event::class)
            ->find($id);
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('AfficheEv');

    }

    public function ModifierEventAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
        $Form = $this->createForm(EventType::class, $event);
        $Form->handleRequest($request);
        if ($Form->isSubmitted()) {
            $em->flush();
            return $this->redirectToRoute('AfficheEv');

        }
        return $this->render('@Baskel/Default/UpdateEvent.html.twig',
            array('f' => $Form->createView()));

    }

}
