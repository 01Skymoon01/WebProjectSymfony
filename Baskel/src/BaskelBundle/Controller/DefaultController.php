<?php

namespace BaskelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Baskel/Default/index.html.twig');
    }
    public function indexAdminAction()
    {
        return $this->render('@Baskel/Default/indexadmin.html.twig');
    }

    public function pdfAction(){
        $snappy = $this->get('knp_snappy.pdf');
        $filename = 'myFirstSnappyPDF';
        $url = 'http://ourcodeworld.com';


        return new Response(
            $snappy->getOutput($url),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }

    public  function  ImgFaqAction(){
        return $this->render('@Baskel/Default/FAQImg.html.twig');
    }
    public function cranksetAction()
    {
        return $this->render('@Baskel/Default/twiget/crankset.html.twig');
    }
    public function wheelAction()
    {
        return $this->render('@Baskel/Default/twiget/wheel.html.twig');
    }
    public function saddleAction()
    {
        return $this->render('@Baskel/Default/twiget/saddle.html.twig');
    }
    public function handlebarsAction()
    {
        return $this->render('@Baskel/Default/twiget/handlebars.html.twig');
    }
    public function GameAction()
    {
        return $this->render('@Baskel/Default/Game/game.html.twig');
    }


}
