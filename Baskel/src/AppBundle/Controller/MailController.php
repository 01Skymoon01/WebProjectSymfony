<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mail;
use AppBundle\Form\MailType;
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
            $username ='achraf9585@gmail.com';
            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($username)
                ->setTo($mail)
              //  ->setBody($objet);
                ->setBody(
                    $this->render('@Baskel/Livreur/mail.txt.twig')
              );
            $this->get('mailer')->send($message);
            $this->get('session')->getFlashBag()->add('notice','Your email was sent successfully !');
        }
        return $this->render('@Baskel/Default/Mail.html.twig', array('f' => $form->createView()));
    }

}
