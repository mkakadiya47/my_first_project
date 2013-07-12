<?php

namespace User\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use User\BlogBundle\Entity\BlogPost ;
use User\BlogBundle\Form\Type\BlogPostType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class BlogController extends Controller
{
    public function postAction(Request $request)
    {
        $session=$this->get('session');
        if(!$session->get('currentUser'))
        {
            return $this->redirect($this->generateUrl('login'));
        }
        $em=  $this->getDoctrine()->getEntityManager();
        $currentUser=  $session->get('currentUser');
        $user = $em->getRepository('UserRegistrationBundle:UserRegistration')->find($currentUser->getId());
        
        $blogPost=new BlogPost();
        $form =  $this->createForm(new BlogPostType(),$blogPost,array('csrf_protection' => false));
        
        if($request->getMethod()=="POST")
        {
            $form->bind($request);
            if($form->isValid())
            {
                $blogPost->setUser($user);
                $blogPost->setCreatedAt(new \DateTime());
                $em->persist($blogPost);
                $em->flush();
                return new Response('true');
            }
        }
        
        return $this->render(
            'BlogBundle:Blog:create_post.html.twig',
            array('form' => $form->createView(),'header_name'=>'Post')
        );
        
    }
    
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {
         $session=$this->get('session');
        if(!$session->get('currentUser'))
        {
            return $this->redirect($this->generateUrl('login'));
        }
        
    }
    
    public function postListAction()
    {
        $session=$this->get('session');
        if(!$session->get('currentUser'))
        {
            return new Response('false');
        }
        
        $em=  $this->getDoctrine()->getEntityManager();
        $userPost=$em->getRepository('BlogBundle:BlogPost');
        $allPost= $userPost->findBy(array(),array('id'=>'DESC'));
        
        return $this->render('BlogBundle::post_list_layout.html.twig',array('posts'=>$allPost));
    }
}
?>
