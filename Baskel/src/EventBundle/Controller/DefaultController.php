<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Event;
use EventBundle\Form\EventType;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Event/Default/index.html.twig');
    }
    public function indexAdminAction()
    {
        return $this->render('@Event/Default/indexadmin.html.twig');
    }


}
