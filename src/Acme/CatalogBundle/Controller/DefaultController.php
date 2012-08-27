<?php

namespace Acme\CatalogBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;


use Acme\CatalogBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
    /**
     * @Route("/catalog")
     */
class DefaultController extends Controller
{


    /**
     * @Route("/")
     * @Template()
     * 
     */
    public function indexAction()
    {       
	$secur =  $this->get('security.context');

	if ((false ===   $secur->isGranted('ROLE_USER')) and  
            (false ===   $secur->isGranted('ROLE_ADMIN')) ){
	         $user = "ГОСТЬ";
                 $auth = 'Для просмотра большего числа товаров  
                           <a href="/login">Авторизируйтесь</a>!<br>
                          Если нет Логина и Пароля   
                           <a href="/registration">Регистрируйтесь</a>!';
        }  else { 
          $user  = $secur->getToken()->getUser()->getUsername();
              $auth = '';
        }

        return $this->render('AcmeCatalogBundle:Default:index.html.twig', 
                    array(
                        'test' => '' , 
                        'welcom' => 'Добро пожаловать ' , 
                        'user'  => $user,
                        'auth'  =>  $auth,
                        //'user' => $this->get('security.context')->getToken()->getUser(),  twig - <center>Welcome, {{ app.user.username }}</center>
               ));
    }
    

    
     /**
     * @Route("/product/")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function productAction()
    {  
        return array('name' => 'NAME PRODUCT');
    }

    
    
         /**
     * @Route("/test/")
     * @Template()
     * @
     */
    public function testAction()
    {        
	//$usr = $this->get('security.context')->getToken()->getUser();
        //$user = $usr->getUsername();
	  $secur =  $this->get('security.context');
                    if ((false ===   $secur->isGranted('ROLE_USER')) ||  
                        (false ===   $secur->isGranted('ROLE_ADMIN')) ){
                            $name = "ГОСТЬ";
                      }  else { 
                         $name = $secur->getToken()->getUser()->getUsername();
                      }
            return array('name' => $name);
    }


    
    /**
     * @Route ("/create/")
     * @Template()
     * 
     */
    public function createAction()
    {
        $product = new Product();
        $product->setName('Notebook');
        $product->setDescription('Description Notebook');
        $product->setImg('/img/notebook.jpg');
        $product->setPrice('19.99');
        $product->setUserid('1');

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($product);
        $em->flush();

        return new Response('Created product id '.$product->getId());
    }
    
    
    
    
    
    
}
