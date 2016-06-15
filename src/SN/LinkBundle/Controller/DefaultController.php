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
    
    public function addAction(Request $request)
    {
        $link = new Link;
        $form = $this->createForm(AddLinkType::class, $link);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($link);
            $em->flush();

            return $this->redirectToRoute('sn_link_add');
        }

        return $this->render('SNLinkBundle:Default:addLink.html.twig', array('form'=>$form->createView(),));
    }

    public function viewAction() {
        $repo = $this->getDoctrine()->getRepository('SNLinkBundle:Link');
        $links = $repo->findAll();

        return $this->render('SNLinkBundle:Default:viewLink.html.twig', array('links'=>$links));
    }

    public function deleteAction(Request $request, $id) {
        {
            $em = $this->getDoctrine()->getManager();
            $link = $em->getRepository('SNLinkBundle:Link')->find($id);

            $em->remove($link);
            $em->flush();

            return $this->redirectToRoute('sn_link_view');

        }
    }
}
