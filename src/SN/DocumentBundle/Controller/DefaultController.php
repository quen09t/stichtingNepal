<?php

namespace SN\DocumentBundle\Controller;

use SN\DocumentBundle\Entity\Document;
use SN\DocumentBundle\Form\DocumentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $document = new Document;
        $form = $this->createForm(DocumentType::class, $document);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($document);
            $em->flush();

            return $this->redirectToRoute('sn_document_homepage');
        }
        return $this->render('SNDocumentBundle:Default:index.html.twig', array('form'=>$form->createView(),));
    }
}
