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
    public function addSponsorAction(Request $request){
        $sponsor = new Sponsor();
        $form = $this->createForm(SponsorType::class, $sponsor);
        
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($sponsor);
            $em->flush();
            
            return $this->redirectToRoute('sn_core_back');
        }
        
        return $this->render('SNSponsorBundle::addSponsor.html.twig', array('form'=>$form->createView()));
        
    }
    public function viewAction (){
        $sponsors = $this->getDoctrine()->getRepository('SNSponsorBundle:Sponsor')->findAll();

        return $this->render('@SNSponsor/viewSponsor.html.twig', array('sponsors'=>$sponsors));
    }
    public function deleteAction($id){
        $sponsor = $this->getDoctrine()->getRepository('SNSponsorBundle:Sponsor')->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($sponsor);
        $em->flush();

        return $this->redirectToRoute('sn_core_back');

    }
    public function editAction(Request $request, $id){
        $sponsor = $this->getDoctrine()->getRepository('SNSponsorBundle:Sponsor')->find($id);
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(SponsorType::class, $sponsor);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em->persist($sponsor);
            $em->flush();

            return $this->redirectToRoute('sn_core_back');
        }

        return $this->render('SNSponsorBundle::editSponsor.html.twig', array('form'=>$form->createView()));

    }



}
