<?php

namespace BaskelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
