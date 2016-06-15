<?php

namespace SN\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackController extends Controller
{
    public function indexAction()
    {
        return $this->render('SNCoreBundle:Back:index.html.twig');
    }
}
