<?php

namespace SN\SponsorBundle\Controller;

use SN\SponsorBundle\Entity\Sponsor;
use SN\SponsorBundle\Form\SponsorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function sponsorsAction()
    {
        $repo = $this->getDoctrine()->getRepository('SNSponsorBundle:Sponsor');

        $sponsors = $repo->findAll();

        return $this->render('SNSponsorBundle::sponsors.html.twig', array('sponsors'=>$sponsors));
    }
}
