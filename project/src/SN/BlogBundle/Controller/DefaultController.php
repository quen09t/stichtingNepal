<?php

namespace SN\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SN\BlogBundle\Entity\Post;
use SN\BlogBundle\Entity\Image;
use SN\BlogBundle\Form\AddPostType;
use SN\ContactBundle\Email\GetAddress;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $posts = $this->getDoctrine()->getRepository('SNBlogBundle:Post')->findAll();


        return $this->render('SNBlogBundle:Default:index.html.twig', array('posts' => $posts));
    }

    public function newestAction(){
        $post = $this->getDoctrine()
            ->getRepository('SNBlogBundle:Post')
            ->findNewest();
        
        return $this->render('SNBlogBundle:Default:newestPost.html.twig', array('post'=>$post));
    }
}
