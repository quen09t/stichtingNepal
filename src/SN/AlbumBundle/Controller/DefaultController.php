<?php

namespace SN\AlbumBundle\Controller;

use SN\AlbumBundle\Entity\Album;
use SN\AlbumBundle\Form\AlbumType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository('SNAlbumBundle:Album');

        $albums = $repo->findAll();

        return $this->render('SNAlbumBundle:Default:index.html.twig', array('albums'=>$albums));
    }
    
    public function addAction(Request $request){
        
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);

        $album->setDateCreated(new \DateTime());


        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($album);


            $em->flush();
            
            return $this->redirectToRoute('sn_album_homepage');
        }
        
        return $this->render('SNAlbumBundle:Default:add.html.twig', array('form'=>$form->createView()));
    }

    public function viewAction(){
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository('SNAlbumBundle:Album');

        $albums = $repo->findAll();

        return $this->render('SNAlbumBundle:Default:view.html.twig', array('albums'=>$albums));
    }
    
    public function editAction() {
        
    }
}
