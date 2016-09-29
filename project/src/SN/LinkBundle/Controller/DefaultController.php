<?php

namespace SN\LinkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SN\LinkBundle\Entity\Link;
use SN\LinkBundle\Form\AddLinkType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository('SNLinkBundle:Link');

        $links= $repo->findAll();
        return $this->render('SNLinkBundle:Default:index.html.twig', array( 'links'=>$links));
    }
}
