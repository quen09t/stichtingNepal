<?php

namespace SN\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SNCoreBundle:Default:index.html.twig');
    }
}
