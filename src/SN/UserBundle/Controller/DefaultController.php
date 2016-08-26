<?php

namespace SN\UserBundle\Controller;

use SN\UserBundle\Form\ChangePasswordType;
use SN\UserBundle\Form\EditProfileType;
use SN\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SNUserBundle:Default:index.html.twig');
    }

    public function viewAction() {
        $repo = $this->getDoctrine()->getRepository('SNUserBundle:User');
        $users = $repo->findAll();
        return $this->render('SNUserBundle:Default:view.html.twig', array('users'=>$users));
    }
    
    public function editAction(Request $request, $id){
        $repo = $this->getDoctrine()->getRepository('SNUserBundle:User');
        $post = $repo->find($id);
        

        $form = $this->createForm(EditProfileType::class, $post);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('sn_blog_homepage');
        }
        return $this->render('SNUserBundle:Default:edit.html.twig', array ( 'form' => $form->createView(),));
    }

    public function changeRoleAction(Request $request){
        if($this->isGranted("ROLE_SUPER_ADMIN"))
        {
            if ($request->isMethod('POST')){
                $id = $request->request->get('id');
                $role = $request->request->get('role');
                $repo = $this->getDoctrine()->getRepository('SNUserBundle:User');
                $user = $repo->find($id);

                $user->removeRole("ROLE_SUPER_ADMIN");
                $user->removeRole("ROLE_ADMIN");
                $user->removeRole("ROLE_VISITOR");

                $user->addRole($role);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('sn_user_view');
        }
            return $this->redirectToRoute('sn_blog_homepage');
        }
        return $this->redirectToRoute('sn_user_view');
    }

    public function changePasswordAction(Request $request, $id){
        $repo = $this->getDoctrine()->getRepository('SNUserBundle:User');
        $post = $repo->find($id);


        $form = $this->createForm(ChangePasswordType::class, $post);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('sn_blog_homepage');
        }
        return $this->render('SNUserBundle:Default:edit.html.twig', array ( 'form' => $form->createView(),));
    }

    public function deleteAction($id){
        if($this->isGranted("ROLE_SUPER_ADMIN")){
            $em = $this->getDoctrine()->getManager();
            $link = $em->getRepository('SNUserBundle:User')->find($id);

            $em->remove($link);
            $em->flush();

            return $this->redirectToRoute('sn_user_view');
        }

        return $this->redirectToRoute('sn_core_homepage');
    }
    
    public function myProfileAction() {
        return $this->render('SNUserBundle:Default:profile.html.twig');
    }
}
