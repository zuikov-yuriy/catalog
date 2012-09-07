<?php
// src/Acme/SecurityBundle/Controller/Main;


namespace Acme\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Acme\CatalogBundle\Form\Type\RegistrationType;
use Acme\CatalogBundle\Form\Model\Registration;

use Acme\CatalogBundle\Entity\User;
use Acme\CatalogBundle\Entity\Role;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;


use Acme\CatalogBundle\Entity\Test;



class SecurityController extends Controller
{
    
    
    
    
    
    
    
    
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // получить ошибки логина, если таковые имеются
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        $secur = $this->get('security.context');
        if (true ===   $secur->isGranted('ROLE_ADMIN')){
             return $this->redirect('/admin');
        }
        
        
        return $this->render('AcmeCatalogBundle:Security:login.html.twig', array(
            // имя, введённое пользователем в последний раз
            'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }
    
    
    public function logoutAction()
    {
       $this->get('security.context')->setToken(null);
       return $this->get('request')->getSession()->invalidate();
    }
    
    

    
    
    
    public function registrationAction(Request $request)
    {
               $user = new User();
               $role = new Role();
               $form = $this->createFormBuilder($user)
                    ->add('firstName', 'text')
                    ->add('lastName', 'text')
                    ->add('email', 'text')
                    ->add('username', 'text')
                    ->add('password', 'repeated', array(
                                                    'first_name' => 'password',
                                                    'second_name' => 'confirm',
                                                    'type' => 'password',
                                                 ))
                    ->add('captcha', 'captcha', array(
                                                    'keep_value' => false,
                                                ))
                    ->getForm();
               
                if ($request->getMethod() == 'POST') {
                      $form->bindRequest($request);
                    if ($form->isValid()) {          
                        $data = $form->getData();
                        $em = $this->getDoctrine()->getEntityManager();
                        
                        $role->setName('ROLE_USER');   //Не правильно );
                        $em->persist($role);

                        $user->setFirstName($data->getFirstName());
                        $user->setLastName($data->getLastName());
                        $user->setEmail($data->getEmail());
                        $user->setUserName($data->getUserName());  //Нужна проверка на присутствие логина
                        $user->setSalt(md5(time()));
                        
                        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
                        $password = $encoder->encodePassword($data->getPassword(), $user->getSalt());
                        $user->setPassword($password);

                        $user->getUserRoles()->add($role);
                        
                         
                        $em->persist($user);
                        $em->flush();
                        return $this->redirect('/');
                        }
                    }
               
               
               return $this->render('AcmeCatalogBundle:Security:registration.html.twig', 
                    array('form' => $form->createView()));
    }
    

       
        
        

        
        
        
     	public function testformAction(Request $request)
            {
               $test = new Test();
               $form = $this->createFormBuilder($test)
                    ->add('name', 'text')
                    ->add('price', 'text')
                    ->add('description', 'text')
                    ->getForm();
               
                if ($request->getMethod() == 'POST') {
                      $form->bindRequest($request);
                    if ($form->isValid()) {          
                        $task = $form->getData();
                        
                        $test->setName($task->getName());
                        $test->setPrice($task->getPrice());
                        $test->setDescription($task->getDescription());

                         $em = $this->getDoctrine()->getEntityManager();
                         $em->persist($test);
                         $em->flush();
                         
                     return $this->redirect('/');
                        }
                    }
    
            
                return $this->render('AcmeCatalogBundle:Security:testform.html.twig', array(
                  'form' => $form->createView(),
                ));     

            }   

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

        
        
    public function newAction(Request $request)
    {
        $task = new Task();
        $form = $this->createFormBuilder($task)
            ->add('task', 'text')
            ->add('dueDate', 'date')
            ->getForm();

        if ($request->getMethod() == 'POST') {$form->bindRequest($request);

            if ($form->isValid()) {
                
                // выполняем прочие действие, например, сохраняем задачу в базе данных
                 return $this->redirect('/');
            }
        }
       return $this->render('AcmeCatalogBundle:Security:new.html.twig', array(
            'form' => $form->createView(),
        ));

    }
    
    
    
    
    
    
}