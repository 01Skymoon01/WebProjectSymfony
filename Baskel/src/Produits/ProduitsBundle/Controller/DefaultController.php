<?php

namespace Produits\ProduitsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Produits/Default/index.html.twig');
    }
}
