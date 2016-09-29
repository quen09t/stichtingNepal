<?php

namespace SN\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackController extends Controller
{
    public function donateAction() {
        return $this->render(('SNCoreBundle:Donation:index.html.twig'));
    }
}
