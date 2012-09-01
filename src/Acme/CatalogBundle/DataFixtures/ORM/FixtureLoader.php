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
        $product = new Product();
        
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
        
        $product->setName('Mazda RX-8');
        $product->setDescription('Super CAR');
        $product->setImg('img/mazda-rx-8.jpg');
        $product->setPrice('16000');
        $product->setUserid('2');
        $manager->persist($product);
        
        $product->setName('Ford Mustang GT');
        $product->setDescription('Super CAR');
        $product->setImg('img/ford-mustang-gt.jpg');
        $product->setPrice('30000');
        $product->setUserid('2');
        $manager->persist($product);
        

        $manager->flush();
    }
 
}
