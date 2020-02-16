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
}
