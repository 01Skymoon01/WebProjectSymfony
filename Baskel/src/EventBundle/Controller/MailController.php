<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Event;
use Produits\ProduitsBundle\Entity\Mail;
use EventBundle\Form\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MailController extends Controller
{


    public function sendMailResponsableAction(Request $request,$id)
    {
        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);
        $event = $this->getDoctrine()->getRepository(Event::class)
            ->find($id);
        if($form->isSubmitted() && $form->isValid())
        {
            $subject = $mail->getSubject();
            $mail = $mail->getMail();
            $objet = $request->get('form')['objet'];
            $username ='ashlynx1997@gmail.com';
            $message = \Swift_Message::newInstance()
                ->setBody($subject)
                ->setFrom($username)
                ->setTo($mail)
                ->setSubject($objet);
            $this->get('mailer')->send($message);

        }
        return $this->render('@Event/Default/Mail.html.twig', array('f' => $form->createView(),
            'event'=>$event
        ));
    }


}
