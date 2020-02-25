<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Event;
use EventBundle\Entity\Reservation;
use EventBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReservationController extends Controller
{
    public function ReservationAction($id)
    {
        $reservation= new Reservation();
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $event = null;
        $event = $this->getDoctrine()->getRepository(Event::class)
            ->findOneBy(array('id'=>$id));
        $event2 = $this->getDoctrine()->getRepository(Event::class)
            ->find($id);




        $em = $this->getDoctrine()->getManager();
        $u= null;
        $u=$em->getRepository(Reservation::class)->findBy(array('id_user'=>$usr));
        $testRes=null;
        $testRes=$this->getDoctrine()->getRepository(Reservation::class)->TestReservation($event->getId(),$usr);


        if($testRes!=null)
        {
            $this->addFlash("error","You have already registered at this event !");
            return $this->redirectToRoute('AfficheEvfront');

        }
        else
        {
            $reservation->setIdEvent($event2);
            $reservation->setIdUser($usr);
            $em->persist($reservation);
            $em->flush();


            return $this->redirectToRoute('AfficheEvfront');

            return $this->render('@Event/Default/AfficheEventsfront.html.twig');
        }

    }

    public function AfficheReservationAction()
    {
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $reservation= $this->getDoctrine()->getRepository(Reservation::class)->findBy(array('id_user'=>$usr));
        return $this->render('@Event/Default/AfficheReservation.html.twig', array(
            "reservation" => $reservation
        ));
    }

    public function AfficheReservationBackAction()
    {

        $reservation= $this->getDoctrine()->getManager()->getRepository(Reservation::class)->findAll();
        $count=$this->getDoctrine()->getRepository(Reservation::class)->NBReservation();
        $count2=$this->getDoctrine()->getRepository(Reservation::class)->NBReservationAnnule();
        $count3=$this->getDoctrine()->getRepository(Reservation::class)->NBReservationfrit();
        return $this->render('@Event/Default/AfficheReservationBack.html.twig', array(
            "reservation" => $reservation,
            "nbconfirme" =>$count,
            "nbannule"=>$count2,
            "nbreserve"=>$count3
        ));
    }


    public function ConfirmerReservationAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reservation=$em->getRepository(Reservation::class)->find($id);

        if($reservation->getEtat()=='reserve')
        {
            $reservation->setEtat('confirme');
            $em->persist($reservation);
            $em->flush();
            $gg=$reservation->getIdUser()->getEmail();
            $message = \Swift_Message::newInstance()
                -> setSubject('confirmation de la reservation !')
                -> setFrom('nizarbenhmida001@gmail.com')
                -> setTo($gg)
                -> setBody('Votre reservation a ete confirmee !');
            $this->get('mailer')->send($message);

        }
        elseif($reservation->getEtat()=='annule')
        {
            $this->addFlash("error","Vous ne pouvez pas confirmer cette reservation");
        }
        else
        {
            $this->addFlash("warning","Votre reservation a ete deja confirmée");
        }

        return $this->redirectToRoute('AfficheRes');
    }

    public function AnnulerReservationAction($id)
    {



        $em=$this->getDoctrine()->getManager();
        $reservation=$em->getRepository(Reservation::class)->find($id);
        if($reservation->getEtat()=='annule')
        {
            $this->addFlash("error","Votre reservation a été déja annulée");
        }
        else
        {
            $reservation->setEtat('annule');
            $em->persist($reservation);
            $em->flush();
            $gg=$reservation->getIdUser()->getEmail();
            $message = \Swift_Message::newInstance()
                -> setSubject('Annulation de la reservation!')
                -> setFrom('nizarbenhmida001@gmail.com')
                -> setTo($gg)
                -> setBody('Votre reservation a ete annulee..tell us the reason?');
            $this->get('mailer')->send($message);
        }

        return $this->redirectToRoute('AfficheRes');
    }



}
