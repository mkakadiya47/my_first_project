<?php

namespace User\RegistrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use User\RegistrationBundle\Entity\UserRegistration;
use User\RegistrationBundle\Form\RegistrationForm;
use User\RegistrationBundle\Form\LoginForm;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use User\RegistrationBundle\Form\ChangePasswordFormType;

class RegistrationController extends Controller
{
    private  $headerName;
   
    public function indexAction(Request $request, $currentUser=null)
    {
        $session=  $this->get('session');
        
        if($currentUser) //edit profile 
        {   
            $em=  $this->getDoctrine()->getEntityManager();
            $updateUser=$em->getRepository('UserRegistrationBundle:UserRegistration')->find($currentUser->getId());
            
            if(!$updateUser)
            {
                throw $this->createNotFoundException('User not found');
            }
            
            $form=  $this->createForm(new RegistrationForm(),$updateUser,array('action'=>  $this->generateUrl('edit_profile')));
            $this->headerName="Edit Profile";
            
            if($request->getMethod()=="POST")
            {
                $form->bind($request);
                if($form->isValid())
                {
                    $updateUser->setCreatedAt(new \DateTime);
                    $updateUser->setUpdatedAt(new \DateTime);
                    $em->persist($updateUser);
                    $session->getFlashBag()->add('notice','Profile successfully saved');
                    $session->set('currentUser',$updateUser);
                    $em->flush();
                    return $this->redirect($this->generateUrl('edit_profile'));
                }
            }
        }
        else  // new profile
        {
            if($session->get('currentUser'))
            {
                return $this->redirect($this->generateUrl('blog_homepage'));
            }
            
            $registrationBundle= new UserRegistration();
            $form=  $this->createForm(new RegistrationForm(1),$registrationBundle,array('action'=>  $this->generateUrl('registration')));
            $this->headerName="Registration";
            
            if($request->getMethod()=="POST")
            {
                $form->bind($request);

                if($form->isValid())
                {
                    $em=  $this->getDoctrine()->getEntityManager();
                    $registrationBundle->setCreatedAt(new \DateTime);
                    $registrationBundle->setUpdatedAt(new \DateTime);
                    $registrationBundle->setIsActive(0);
                    $registrationBundle->setToken(sha1($registrationBundle->getEmail()));
                    $this->sendMail($registrationBundle->getFirstName(),$registrationBundle->getEmail(),  $registrationBundle->getToken(),$request);
                    $em->persist($registrationBundle);
                    $em->flush();
                    return $this->redirect($this->generateUrl('login'));
                }
            }
        }
        
        return $this->render('UserRegistrationBundle:Registration:index.html.twig',array('form'=>$form->createView(),'header_name'=>  $this->headerName));
    }
    
    public function loginAction(Request $request)
    {
        $session=  $this->get('session');
        if($session->get('currentUser'))
        {
            return $this->redirect($this->generateUrl('post'));
        }
        
        $form= $this->createForm(new LoginForm());
        $em=  $this->getDoctrine()->getEntityManager()->getRepository('UserRegistrationBundle:UserRegistration');
        
        if($request->getMethod()=="POST")
        {
            $form->bind($request);
            if($form->isValid())
            {
                $data=$em->findBy(array('email'=>$form['email']->getData(),'password'=>$form['password']->getData()));
                if($data)
                {
                    if($data[0]->getIsActive()==1)
                    {
                        $session->set('currentUser', $data[0]);
                        return $this->redirect($this->generateUrl('blog_homepage'));
                    }
                    else
                    {
                        $session->getFlashBag()->add('error','Not approved by admin !!');
                        return $this->redirect($this->generateUrl('login'));
                    }
                }
                else 
                {
                    $session->getFlashBag()->add('error','Email or Password wrong !!');
                    return $this->redirect($this->generateUrl('login'));
                }
                
            }
        }
        return $this->render('UserRegistrationBundle:Registration:login.html.twig',array('form'=>$form->createView(),'header_name'=>'Login'));
    }
    
    public function editProfileAction(Request $request)
    {
        $session=  $this->get('session');
        if(!$session->get('currentUser'))
        {
            return $this->redirect($this->generateUrl('login'));
        }
        
        $session=  $this->get('session');
        $currentUser=$session->get('currentUser');
        return $this->indexAction($request,$currentUser);
    }
    
    public function changePasswordAction(Request $request)
    {
        $session=  $this->get('session');
        if(!$session->get('currentUser'))
        {
            return $this->redirect($this->generateUrl('login'));
        }
        
        $currentUser=  $this->get('session')->get('currentUser');
        $em=  $this->getDoctrine()->getEntityManager();
        $userPassword=$em->getRepository('UserRegistrationBundle:UserRegistration')->find($currentUser->getId());
        $form=  $this->createForm(new ChangePasswordFormType(),null,array('action'=>  $this->generateUrl('change_user_password')));
        
        if ($request->getMethod()=="POST")
        {
            $form->bind($request);
            if ($form->isValid())
            {
                if(!$form['new_password']->getData()==$form['conf_password']->getData())
                {
                    $session->getFlashBag()->add('error','Password not match !!');
                } 
                else
                if($form['current_password']->getData()==$currentUser->getPassword())
                {
                    $userPassword->setPassword($form['new_password']->getData());
                    $em->persist($userPassword);
                    $em->flush();
                    $session->set('currentUser',$userPassword);
                    $session->getFlashBag()->add('notice','Password changed!!! ');
                }
                else 
                {
                    $session->getFlashBag()->add('error','Current password is wrong !!');
                }
                
            }
            else
            {
                $session->getFlashBag()->add('error','Please fill password !!');
            }
        }
        
        
        return $this->render('UserRegistrationBundle:Registration:change_password.html.twig',array('form'=>$form->createView()));
    }

    public function logoutAction()
    {
        $session=  $this->get('session');
        $session->remove('currentUser');
        $session->invalidate();
        return $this->redirect($this->generateUrl('login'));
    }

    public function sendMail($name,$email,$token,$request) {
        
        $message = \Swift_Message::newInstance()
        ->setSubject('Welcome, '.$name)
        ->setFrom('mkakadiya47job@gmail.com','Manoj Kakadiya')
        ->setTo($email)
        ->setContentType('text/html')
        
        ->setBody('<h3>welcome, '.$name.'</h3><br><br><h4><p>         To finish activating your account <br> please visit :- http://'.$request->getHost().$this->generateUrl('conform_email',array('token'=>$token)).'</p><h4>')
        ;

        $this->get('mailer')->send($message);

    }
    
    public function confirmEmailAction($token = null )
    {
        $em=  $this->getDoctrine()->getEntityManager();
        $confUser=$em->getRepository("UserRegistrationBundle:UserRegistration")->findBy(array('token'=>$token));
        
        if(!$confUser)
        {
            return new Response("<h1>Stupid boy</h1>");
        }
        else
        if($confUser[0]->getIsActive()==1)
        {
             $this->get('session')->getFlashBag()->add('notice','Already Actived!!!!!!!!!');
            $em->flush();
            return $this->redirect($this->generateUrl('login'));
        }
        else
        {
            $confUser[0]->setIsActive(1);
            $em->persist($confUser[0]);
            $this->get('session')->getFlashBag()->add('notice','Activation successful!!!!!!!!!');
            $em->flush();
            return $this->redirect($this->generateUrl('login'));
        }
        
    }
}
?>
