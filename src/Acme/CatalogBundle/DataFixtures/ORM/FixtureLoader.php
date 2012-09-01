<?php
namespace Acme\CatalogBundle\DataFixtures\ORM;
 
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Acme\CatalogBundle\Entity\User;
use Acme\CatalogBundle\Entity\Role;
use Acme\CatalogBundle\Entity\Product;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
 
class FixtureLoader implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $role = new Role();
        $user = new User();
        $role->setName('ROLE_ADMIN');
        $manager->persist($role);
        $user->setFirstName('yuriy');
        $user->setLastName('zuikov');
        $user->setEmail('yuriy@zuikov.org.ua');
        $user->setUsername('admin');
        $user->setSalt(md5(time()));
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword('admin', $user->getSalt());
        $user->setPassword($password);
        $user->getUserRoles()->add($role);
        $manager->persist($user);
        

        $role = new Role();
        $user = new User();
        $role->setName('ROLE_USER');
        $manager->persist($role);
        $user->setFirstName('user');
        $user->setLastName('user');
        $user->setEmail('user@user.user');
        $user->setUsername('user');
        $user->setSalt(md5(time()));
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword('user', $user->getSalt());
        $user->setPassword($password);
        $user->getUserRoles()->add($role);
        $manager->persist($user);
        
        
        $role = new Role();
        $user = new User();
        $role->setName('ROLE_USER');
        $manager->persist($role);
        $user->setFirstName('test');
        $user->setLastName('test');
        $user->setEmail('test@test.test');
        $user->setUsername('test');
        $user->setSalt(md5(time()));
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword('test', $user->getSalt());
        $user->setPassword($password);
        $user->getUserRoles()->add($role);
        $manager->persist($user);
        
        
        
        
        
        
        
        
        
        $product = new Product();
        $product->setName('Audi A4 Quattro');
        $product->setDescription('Super CAR');
        $product->setImg('img/user/audi-a4-quattro.jpg');
        $product->setPrice('150000');
        $product->setUserid('2');
        $manager->persist($product);

        $product = new Product();
        $product->setName('Audi R8 Coupe');
        $product->setDescription('Super CAR');
        $product->setImg('img/user/audi-r8-coupe.jpg');
        $product->setPrice('155000');
        $product->setUserid('2');
        $manager->persist($product);
        
        $product = new Product();
        $product->setName('BMW 1 series 3');
        $product->setDescription('Super CAR');
        $product->setImg('img/user/bmw1series3dat.jpg');
        $product->setPrice('125000');
        $product->setUserid('2');
        $manager->persist($product);     
        
        $product = new Product();
        $product->setName('BMW Z4');
        $product->setDescription('Super CAR');
        $product->setImg('img/user/bmw-z4.jpg');
        $product->setPrice('185000');
        $product->setUserid('2');
        $manager->persist($product);        
        
        $product = new Product();
        $product->setName('Ferrari California');
        $product->setDescription('Super CAR');
        $product->setImg('img/user/ferrari-california.jpg');
        $product->setPrice('1850000');
        $product->setUserid('2');
        $manager->persist($product);      
        
        $product = new Product();
        $product->setName('Porshe Panamera 4s');
        $product->setDescription('Super CAR');
        $product->setImg('img/user/porshe-panamera-4s.jpg');
        $product->setPrice('1100000');
        $product->setUserid('2');
        $manager->persist($product);      
        
        
        

        
        
        $product = new Product();
        $product->setName('Audi A1');
        $product->setDescription('Super CAR');
        $product->setImg('img/test/audi-a1.jpg');
        $product->setPrice('105000');
        $product->setUserid('3');
        $manager->persist($product);
        
        $product = new Product();
        $product->setName('Audi TTS Coupe');
        $product->setDescription('Super CAR');
        $product->setImg('img/test/audi-tts-coupe.jpg');
        $product->setPrice('115000');
        $product->setUserid('3');
        $manager->persist($product);
        
        $product = new Product();
        $product->setName('BMW 1 series 5d 2011');
        $product->setDescription('Super CAR');
        $product->setImg('img/test/bmw1-series5d-2011.jpg');
        $product->setPrice('125000');
        $product->setUserid('3');
        $manager->persist($product); 
        
        $product = new Product();
        $product->setName('BMW 5 series turing');
        $product->setDescription('Super CAR');
        $product->setImg('img/test/bmw-5series-turing.jpg');
        $product->setPrice('156000');
        $product->setUserid('3');
        $manager->persist($product);     
       
        $product = new Product();
        $product->setName('Ferrari FF');
        $product->setDescription('Super CAR');
        $product->setImg('img/test/ferrari-ff.jpg');
        $product->setPrice('2056000');
        $product->setUserid('3');
        $manager->persist($product);
        
        $product = new Product();
        $product->setName('Porshe Cayenne S');
        $product->setDescription('Super CAR');
        $product->setImg('img/test/porshe-cayenne-s.jpg');
        $product->setPrice('1256000');
        $product->setUserid('3');
        $manager->persist($product);     
        
        $manager->flush();
    }

}
