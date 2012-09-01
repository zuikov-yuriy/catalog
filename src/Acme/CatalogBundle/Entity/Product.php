<?php

namespace Acme\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\CatalogBundle\Entity\Product
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Product
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var text $img
     *
     * @ORM\Column(name="img", type="text")
     */
    private $img;

    /**
     * @var float $price
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    

    
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="uid")
     * @ORM\JoinColumn(name="userid", referencedColumnName="id")
     */
    protected $users;
    
    
    
    
    
    
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set img
     *
     * @param text $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * Get img
     *
     * @return text 
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set price
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set userid
     *
     * @param float $userId
     */
    public function setUserId($userId)
    {
        $this->userid = $userId;
    }

    /**
     * Get userid
     *
     * @return float 
     */
    public function getUserId()
    {
        return $this->userid;
    }



    /**
     * Set users
     *
     * @param Acme\CatalogBundle\Entity\User $users
     */
    public function setUsers(\Acme\CatalogBundle\Entity\User $users)
    {
        $this->users = $users;
    }

    /**
     * Get users
     *
     * @return Acme\CatalogBundle\Entity\User 
     */
    public function getUsers()
    {
        return $this->users;
    }

}