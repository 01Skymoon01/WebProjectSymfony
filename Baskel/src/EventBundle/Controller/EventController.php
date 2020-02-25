<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Event;
use EventBundle\Form\Event1Type;
use EventBundle\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            /**
             * @var UploadedFile $file
             */
            $file = $event->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$fileName
            );
            $event->setImage($fileName);
            $em->persist($event);
            $em->flush();
            $this->addFlash("success","You have added an event successfully !");
            return $this->redirectToRoute('AfficheEv');
        }
        return $this->render('@Event/Default/NOCSSAjoutEvent.html.twig', array('f' => $form->createView()));
    }

    public function AfficheEventAction()
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findAll();
        $doctrine =$this->getDoctrine();

        $topEvent=$this->getDoctrine()->getRepository(Event::class)->getTopEvent();
        $worstEvent=$this->getDoctrine()->getRepository(Event::class)->getWorstEvent();
        $closestEvent=$this->getDoctrine()->getRepository(Event::class)-> ClosestEvent();
        return $this->render('@Event/Default/afficheEvents.html.twig', array(
            "events" => $events,
            'topEvent'=>$topEvent,
            'worstEvent'=>$worstEvent,
            'closestEvent'=>$closestEvent
        ));
    }
    public function AfficheEventFrontAction()
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render('@Event/Default/afficheEventsfront.html.twig', array(
            "events" => $events
        ));
    }


    function SupprimerEventAction($id,Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $id= $request->get('id');

            $em = $this->getDoctrine()->getManager();
            $event = $this->getDoctrine()->getRepository(Event::class)
                ->find($id);
            $em->remove($event);
            $em->flush();

            return new JsonResponse('good');

        }

    }

    public function ModifierEventAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);
        $Form = $this->createForm(Event1Type::class, $event);
        $Form->handleRequest($request);
        if ($Form->isSubmitted()) {
            /**
             * @var UploadedFile $file
             */
            $file = $event->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$fileName
            );
            $event->setImage($fileName);
            $em->flush();
            return $this->redirectToRoute('AfficheEv');

        }
        return $this->render('@Event/Default/UpdateEvent.html.twig',
            array('f' => $Form->createView()));

    }

    public function AlertDate(){



    }
    /*
        public function TopEventAction()
        {
            $doctrine =$this->getDoctrine();
            $repository =$doctrine->getRepository('BaskelBundle:Event');
            $topEvent=$this->getDoctrine()->getRepository(Event::class)->getTopEvent();
            var_dump($topEvent);
            return $this->render('@Event/Default/afficheEvents.html.twig',array(
                'topEvent'=>$topEvent
            ));
        }*/

    public function calendarAction()
    {
        return $this->render('@Event/Default/calendar.html.twig');
    }

}
