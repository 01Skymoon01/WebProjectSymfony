<?php

namespace BaskelBundle\Controller;

use BaskelBundle\Entity\Mail;
use BaskelBundle\Form\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MailController extends Controller
{
    public function sendMailAction(Request $request)
    {
        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $subject = $mail->getSubject();
            $mail = $mail->getMail();
            $objet = $request->get('form')['objet'];
            $username ='nizarbenhmida001@gmail.com';
            $message = \Swift_Message::newInstance()
                ->setBody($subject)
                ->setFrom($username)
                ->setTo($mail)
                ->setSubject($objet);
            $this->get('mailer')->send($message);

        }
        return $this->render('@Baskel/Default/Mail.html.twig', array('f' => $form->createView()));
    }
}
