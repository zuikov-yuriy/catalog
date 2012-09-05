<?php
//phpunit -c app src/Acme/CatalogBundle/Tests/Controller/DefaultController.php

namespace Acme\CatalogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    
  public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $link = $crawler->filter('a:contains("Авторизируйтесь")')->eq(0)->link();

        $crawler = $client->click($link);
         

    }
    
    
  public function testAdmin()
    {

         

    }
    
}