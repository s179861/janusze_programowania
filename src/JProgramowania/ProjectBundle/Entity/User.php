<?php

namespace JProgramowania\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
  * @ORM\Entity
  * @ORM\Table(name="users")
  */
 class User implements UserInterface, \Serializable
 {
     /**
      * @ORM\Column(type="integer")
      * @ORM\Id
      * @ORM\GeneratedValue(strategy="AUTO")
      */
     private $id;

     /**
      * @ORM\Column(type="string", length=25, unique=true)
      */
     private $username;

     /**
      * @ORM\Column(type="string", length=64)
      */
     private $password;

     /**
      * @ORM\Column(type="string", length=60, unique=true)
      */
     private $email;
	 
	 /**
      * @ORM\Column(type="string", length=50)
      */
     private $firstname;
	 
	 /**
      * @ORM\Column(type="string", length=50)
      */
     private $lastname;

     /**
      * @ORM\Column(name="is_active", type="boolean")
      */
     private $isActive;
	/**
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="user")
     */
    private $reservations;
    /**
     * @ORM\OneToMany(targetEntity="Hire", mappedBy="user")
     */
    private $hires;

     public function __construct($username, $password, $email, $firstname, $lastname)
     {
		$this->username = $username;
        $this->setAndCodeBcryptPassword($password);
        $this->email = $email;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
        $this->isActive = true;
        $this->reservations = new ArrayCollection();
        $this->hires = new ArrayCollection();
     }

     public function getUsername()
     {
         return $this->username;
     }

     public function getSalt()
     {
         return null;
     }

     public function getPassword()
     {
         return $this->password;
     }

     public function getRoles()
     {
         return array('ROLE_USER');
     }

     public function eraseCredentials()
     {
     }

     public function serialize()
     {
         return serialize(array(
             $this->id,
             $this->username,
             $this->password,
         ));
     }

     public function unserialize($serialized)
     {
         list (
             $this->id,
             $this->username,
             $this->password,
         ) = unserialize($serialized);
     }
 
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    public function setAndCodeBcryptPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add reservations
     *
     * @param \JProgramowania\ProjectBundle\Entity\Reservation $reservations
     * @return User
     */
    public function addReservation(\JProgramowania\ProjectBundle\Entity\Reservation $reservations)
    {
        $this->reservations[] = $reservations;
    
        return $this;
    }

    /**
     * Remove reservations
     *
     * @param \JProgramowania\ProjectBundle\Entity\Reservation $reservations
     */
    public function removeReservation(\JProgramowania\ProjectBundle\Entity\Reservation $reservations)
    {
        $this->reservations->removeElement($reservations);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * Add hires
     *
     * @param \JProgramowania\ProjectBundle\Entity\Hire $hires
     * @return User
     */
    public function addHire(\JProgramowania\ProjectBundle\Entity\Hire $hires)
    {
        $this->hires[] = $hires;
    
        return $this;
    }

    /**
     * Remove hires
     *
     * @param \JProgramowania\ProjectBundle\Entity\Hire $hires
     */
    public function removeHire(\JProgramowania\ProjectBundle\Entity\Hire $hires)
    {
        $this->hires->removeElement($hires);
    }

    /**
     * Get hires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHires()
    {
        return $this->hires;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }
}