<?php

namespace Acme\CatalogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @var integer $id
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length="255", name="first_name")
     * 
     * @var string $firstName
     */
    protected $firstName;
    
    /**
     * @ORM\Column(type="string", length="255", name="last_name")
     * 
     * @var string $lastName
     */
    protected $lastName;
    
    /**
     * @ORM\Column(type="string", length="255")
     * 
     * @var string $email
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length="255")
     *
     * @var string username
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length="255")
     *
     * @var string password
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length="255")
     *
     * @var string salt
     */
    protected $salt;
    
    /**
     * @ORM\Column(type="datetime", name="created_at")
     * 
     * @var DateTime $createdAt
     */
    protected $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="user_role",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection $userRoles
     */
    protected $userRoles;
    
    
    
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="users")
     */
    protected $uid;

 
    
    
    
    
    /**
     * Constructs a new instance of User
     */
    public function __construct()
    {
        $this->uid = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }
    
    
    
    
    
    /**
     * Gets the id.
     * 
     * @return integer The id
     */
    public function getId()
    {
        return $this->id;
    }
    
    
    /**
     * Gets the user's first name.
     * 
     * @return string The first name
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    /**
     * Sets the user's first name.
     * 
     * @param string $value The first name
     */
    public function setFirstName( $value )
    {
        $this->firstName = $value;
    }
    
    /**
     * Gets the user's last name.
     * 
     * @return string The last name
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * Sets the user's last name.
     * 
     * @param string $value The last name
     */
    public function setLastName( $value )
    {
        $this->lastName = $value;
    }
    
    /**
     * Gets the user's email address.
     * 
     * @return string The email
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Sets the user's email address.
     * 
     * @param string $value The email
     */
    public function setEmail($value)
    {
        $this->email = $value;
    }

    /**
     * Gets the username.
     *
     * @return string The username.
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the username.
     *
     * @param string $value The username.
     */
    public function setUsername($value)
    {
        $this->username = $value;
    }

    /**
     * Gets the user password.
     *
     * @return string The password.
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the user password.
     *
     * @param string $value The password.
     */
    public function setPassword($value)
    {
        $this->password = $value;
    }

    /**
     * Gets the user salt.
     *
     * @return string The salt.
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Sets the user salt.
     *
     * @param string $value The salt.
     */
    public function setSalt($value)
    {
        $this->salt = $value;
    }
    
    /**
     * Gets an object representing the date and time the user was created.
     * 
     * @return DateTime A DateTime object
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Gets the user roles.
     *
     * @return ArrayCollection A Doctrine ArrayCollection
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }
    
    
    /**
     * Gets the full name of the user.
     * 
     * @return string The full name
     */
    public function getFullName()
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }

    /**
     * Erases the user credentials.
     */
    public function eraseCredentials()
    {

    }

    /**
     * Gets an array of roles.
     * 
     * @return array An array of Role objects
     */
    public function getRoles()
    {
        return $this->getUserRoles()->toArray();
    }

    /**
     * Compares this user to another to determine if they are the same.
     * 
     * @param UserInterface $user The user
     * @return boolean True if equal, false othwerwise.
     */
    public function equals(UserInterface $user)
    {
        return md5($this->getUsername()) == md5($user->getUsername());
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Add userRoles
     *
     * @param Acme\CatalogBundle\Entity\Role $userRoles
     */
    public function addRole(\Acme\CatalogBundle\Entity\Role $userRoles)
    {
        $this->userRoles[] = $userRoles;
    }

    /**
     * Add uid
     *
     * @param Acme\CatalogBundle\Entity\Product $uid
     */
    public function addProduct(\Acme\CatalogBundle\Entity\Product $uid)
    {
        $this->uid[] = $uid;
    }

    /**
     * Get uid
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUid()
    {
        return $this->uid;
    }
}