<?php

namespace SN\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SN\BlogBundle\Entity\Post;
use SN\BlogBundle\Entity\Image;
use SN\BlogBundle\Form\AddPostType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $posts = $this->getDoctrine()->getRepository('SNBlogBundle:Post')->findAll();


        return $this->render('SNBlogBundle:Default:index.html.twig', array('posts' => $posts));
    }

    public function addAction(Request $request) {
        $post = new Post;
        $form = $this->createForm(AddPostType::class, $post);

        $post->setCreatedBy($this->getUser());
        $post->setCreatedOn( new \DateTime());

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('sn_blog_homepage');
        }

        return $this->render('SNBlogBundle:Default:add.html.twig', array ( 'form' => $form->createView(),));
    }
    
    public function viewAction() {
        $repo = $this->getDoctrine()->getRepository('SNBlogBundle:Post');
        $posts = $repo->findAll();
        
        return $this->render('SNBlogBundle:Default:view.html.twig', array('posts'=>$posts));
    }
    
    public function deleteAction($id) {
        $repo = $this->getDoctrine()->getRepository('SNBlogBundle:Post');
        $post = $repo->find($id);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        
        return $this->redirectToRoute('sn_blog_view');
    }

    public function editAction(Request $request, $id){
        $repo = $this->getDoctrine()->getRepository('SNBlogBundle:Post');
        $post = $repo->find($id);

        if (!$this->isGranted('edit', $post))
            return $this->redirectToRoute('sn_blog_homepage');

        $post->setUpdatedBy($this->getUser());
        $post->setUpdatedOn( new \DateTime());

        $form = $this->createForm(AddPostType::class, $post);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('sn_blog_homepage');
        }

        return $this->render('SNBlogBundle:Default:add.html.twig', array ( 'form' => $form->createView(),));

    }
    
    public function newestAction(){
        $post = $this->getDoctrine()
            ->getRepository('SNBlogBundle:Post')
            ->findNewest();
        
        return $this->render('SNBlogBundle:Default:newestPost.html.twig', array('post'=>$post));
    }
}
