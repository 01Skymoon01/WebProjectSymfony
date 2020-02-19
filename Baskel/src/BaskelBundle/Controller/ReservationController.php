<?php

namespace BaskelBundle\Controller;

use BaskelBundle\Entity\Event;
use BaskelBundle\Entity\Reservation;
use BaskelBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReservationController extends Controller
{
    public function ReservationAction($id)
    {
        $reservation= new Reservation();
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $event = $this->getDoctrine()->getRepository(Event::class)
            ->find($id);
        $em = $this->getDoctrine()->getManager();
        $u= null;
        $u=$em->getRepository(User::class)->findBy(array('id'=>$usr));
        if($u!=null)
        {
            $this->addFlash("error","You have already registered at this event !");
            return $this->redirectToRoute('AfficheEvfront');

        }
        else
            {
                $reservation->setIdEvent($event);
                $reservation->setIdUser($usr);
                $em->persist($reservation);
                $em->flush();


                return $this->redirectToRoute('AfficheEvfront');

                return $this->render('@Baskel/Default/AfficheEventsfront.html.twig');
        }

    }

    public function AfficheReservationAction()
    {
        $reservation= $this->getDoctrine()->getRepository(Reservation::class)->findAll();
        return $this->render('@Baskel/Default/AfficheReservation.html.twig', array(
            "reservation" => $reservation
        ));
    }

    public function ConfirmerReservationAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reservation=$em->getRepository(Reservation::class)->find($id);
        $reservation->setEtat('confirme');
        $em->persist($reservation);
        $em->flush();

        $message = \Swift_Message::newInstance()
            -> setSubject('confirmation de la reservation !')
            -> setFrom('nizarbenhmida001@gmail.com')
            -> setTo('nizarbenhmida001@gmail.com')
            -> setBody('Votre reservation a ete confirmee !');
        $this->get('mailer')->send($message);
        return $this->redirectToRoute('AfficheRes');
    }

    public function AnnulerReservationAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reservation=$em->getRepository(Reservation::class)->find($id);
        $reservation->setEtat('annule');
        $em->persist($reservation);
        $em->flush();
        $message = \Swift_Message::newInstance()
            -> setSubject('Annulation de la reservation!')
            -> setFrom('nizarbenhmida001@gmail.com')
            -> setTo('nizarbenhmida001@gmail.com')
            -> setBody('Votre reservation a ete annulee..tell us the reason?');
        $this->get('mailer')->send($message);
        return $this->redirectToRoute('AfficheRes');
    }



}
