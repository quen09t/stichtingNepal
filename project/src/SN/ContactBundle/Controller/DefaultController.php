<?php

namespace SN\ContactBundle\Controller;

use SN\ContactBundle\Entity\Message;
use SN\ContactBundle\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $message = new Message;
        $form = $this->createForm(MessageType::class, $message);
        
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('sn_blog_homepage');
        }

        return $this->render('SNContactBundle:Default:index.html.twig', array('form' => $form->createView(),));
    }
}
