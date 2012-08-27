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
        $usr = $this->get('security.context')->getToken()->getUser();
        
        return array(
                     'test' => 'test' , 
                     'name' => 'welcom to catalog' , 
                     'usr'  => $usr->getUsername(),
                     'user' => $this->get('security.context')->getToken()->getUser(),
                );
        

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
