<?php

namespace Acme\CatalogBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;

use Acme\CatalogBundle\Entity\Product;
use Acme\CatalogBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {      
	$secur = $this->get('security.context');

	if ((false ===   $secur->isGranted('ROLE_USER')) and  
            (false ===   $secur->isGranted('ROLE_ADMIN')) ){
	         $info['user'] = "ГОСТЬ";
                 $info['auth'] = 'Для просмотра большего числа товаров  <a href="/login">Авторизируйтесь</a>!<br>Если нет Логина и Пароля   <a href="/registration">Регистрируйтесь</a>!';
                 $info['title'] = 'Количество товаров для не авторизованного пользователя ограниченно!';
                 
                 $repository = $this->getDoctrine()->getRepository('AcmeCatalogBundle:Product');
                 $query = $repository->createQueryBuilder('p')
                        ->getQuery()
                        ->setMaxResults(4);
                 $product = $query->getResult();

                 //  foreach ($product as $p) {
                 //   $idd .= $p->getUsers()-> getUsername();
                 // }
    
                  
             }  else { 
                // if (true === $secur->isGranted('ROLE_USER')) {return $this->redirect('/user/'.$uid);}
                 $info['user']  = $secur->getToken()->getUser()->getUsername();
                 $info['auth'] = '';
                 $info['title'] = '';  
                 $product = $this->getDoctrine()
                        ->getRepository('AcmeCatalogBundle:Product')
                        ->findByUsers($secur->getToken()->getUser()->getId());
                 
        
                }

     return array('info'  =>  $info, 'products' => $product,  );
    }
    

    
   public function adminAction(Request $request)
       {       
            $users = $this->getDoctrine()
                    ->getRepository('AcmeCatalogBundle:User')
                    ->findAll();

            foreach ($users as $u) {
                $key = $u->getId();
                $value = $u->getUsername();
                $k = $value.'-'.$key;
                $userSelect[$k] = $value.'(id - '.$key.')';
             }

               $product = new Product();
               $form = $this->createFormBuilder($product)
                    ->add('Name', 'text')
                    ->add('Description', 'text')
                    ->add('Img', 'file')
                    ->add('Price', 'text')
                    ->add('Users', 'choice', array(
                            'choices'=>$userSelect,
                            'required' => false,
                          ))
                    ->getForm();
       
               if ($request->getMethod() == 'POST') {
                      $form->bindRequest($request);
                    if ($form->isValid()) {   
                        
                        $file = $form['Img']->getData();
                        $secur = $this->get('security.context');
                        
                        $uf = explode("-" , $product->getUsers());
                        $file->move($_SERVER['DOCUMENT_ROOT'].'/Symfony/img/'.$uf[0], $file->getClientOriginalName());
                        
                         $create = $form->getData();
                         
                         $product->setUsers($uf[1]);
                         $product->setImg('img/'.$uf[0].'/'.$file->getClientOriginalName()); 
                         
                         $em = $this->getDoctrine()->getEntityManager();
                         $em->persist($create);
                         $em->flush();
                        }
                    }
               
               $products = $this->getDoctrine()
                        ->getRepository('AcmeCatalogBundle:Product')
                        ->findAll();
               

               
          return $this->render('AcmeCatalogBundle:Default:admin.html.twig', 
                    array('form' => $form->createView(), 'products'=>$products ));
       }

       
       
      /**
       * @Route("/admin/editproduct/{id}")
       * @Template()
       * 
       */
    public function editproductAction($id)
       { 
          $em = $this->getDoctrine()->getEntityManager();
          $product = $em->getRepository('AcmeCatalogBundle:Product')->find($id);
        
          $users = $this->getDoctrine()
                    ->getRepository('AcmeCatalogBundle:User')
                    ->findAll();

          return $this->render('AcmeCatalogBundle:Default:editproduct.html.twig', 
             array('product' => $product, 'users' => $users,  ));
       }
       

       
      /**
       * @Route("/admin/updateproduct")
       * @Template()
       * 
       */
    public function updateproductAction()
       { 
               $request = Request::createFromGlobals();
               $post = $request->request;
               
               $em = $this->getDoctrine()->getEntityManager();
               
               $product = $em->getRepository('AcmeCatalogBundle:Product')->find($post->get('id'));
               $user = $em->getRepository('AcmeCatalogBundle:User')->find($post->get('userid'));
               
               $product->setName($post->get('name'));
               $product->setDescription($post->get('description'));
               $product->setImg($post->get('img'));
               $product->setPrice($post->get('price'));
               
               $product->setUsers($user);
               
               
               $em->flush();
               
               return $this->redirect('/admin');
       
       }
       
 
       
      /**
       * @Route("/admin/deleteproduct/{id}")
       * @Template()
       * 
       */
    public function deleteproductAction(Request $request, $id)
       { 
            
          $em = $this->getDoctrine()->getEntityManager();
          $product = $em->getRepository('AcmeCatalogBundle:Product')->find($id);             
          $em->remove($product);
          $em->flush();
  
          return $this->render('AcmeCatalogBundle:Default:deleteproduct.html.twig', 
             array('id' => $id,));
       }
       
       
      

       
      /**
       * @Route("/redirect")
       * @Template()
       * 
       */
    public function redirectAction()
       { 
           if (true === $this->get('security.context')->isGranted('ROLE_ADMIN') ) {
                return $this->redirect('/admin');
           }
           
           else if (true === $this->get('security.context')->isGranted('ROLE_USER') ) {
                return $this->redirect('/');
           }
           
       }
       
       
       
       
       
       /**
       * @Route("/user/{id}/")
       * @Template()
       * @Secure(roles="ROLE_USER")
       */
    public function userAction($id)
       {  
           return array('name' => 'Пользователь', 'id' => $id);
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
   * @Route("/refresh")
   * @Template()
   * 
   */
    public function refreshAction()
    {
        $session                = $this->container->get('session');       
        $gregwarCaptchaConfig   = $this->container->getParameter('gregwar_captcha.config');       
        $captchaType            = new \Gregwar\CaptchaBundle\Type\CaptchaType($session, $gregwarCaptchaConfig);
        $key                    = $captchaType->getName();

        
        
        $value = '';
        $chars = str_split($gregwarCaptchaConfig['charset']);

        for ($i=0; $i<$gregwarCaptchaConfig['length']; $i++) {
            $value.= $chars[array_rand($chars)];
        }

        $session->set($key, $value);
       

        $generator = new \Gregwar\CaptchaBundle\Generator\CaptchaGenerator(
            $value,
            $gregwarCaptchaConfig['image_folder'],
            $gregwarCaptchaConfig['web_path'],
            $gregwarCaptchaConfig['gc_freq'],
            $gregwarCaptchaConfig['expiration'],
            $gregwarCaptchaConfig['font'],
            null,
            $gregwarCaptchaConfig['quality']
        );
        $src = $generator->getCode($gregwarCaptchaConfig['width'], $gregwarCaptchaConfig['height']);

        $img = '<img src="'.$src.'"/>';

        return new Response($img);
  
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
