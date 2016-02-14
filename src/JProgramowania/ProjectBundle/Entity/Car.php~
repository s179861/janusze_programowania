<?php

    namespace JProgramowania\ProjectBundle\Entity;
    use Doctrine\ORM\Mapping as ORM;
    use Doctrine\Common\Collections\ArrayCollection;
    
    /**
     * @ORM\Entity(repositoryClass="JProgramowania\ProjectBundle\Entity\CarRepository")
     * @ORM\Table(name="cars")
     */
    class Car
    {
        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        private $id;
        /**
         * @ORM\Column(type="string", length=200)
         */
        private $name;
        /**
         * @ORM\Column(type="string", length=200)
         */
        private $segment;
        /**
         * @ORM\Column(type="decimal", scale=2)
         */
        private $price;
        /**
         * @ORM\Column(type="integer")
         */
        private $quantity;
        /**
         * @ORM\OneToMany(targetEntity="Reservation", mappedBy="car")
         */
        private $reservations;
        /**
         * @ORM\OneToMany(targetEntity="Hire", mappedBy="car")
         */
        private $hires;

        public function __construct($name, $segment, $price, $quantity)
        {
            $this->name = $name;
            $this->segment = $segment;
            $this->price = $price;
            $this->quantity = $quantity;
            $this->reservations = new ArrayCollection();
            $this->hires = new ArrayCollection();
        }

        public function getId()
        {
            return $this->id;
        }

        public function getName()
        {
            return $this->name;
        }

        public function getSegment()
        {
            return $this->segment;
        }

        public function getPrice()
        {
            return $this->price;
        }

        public function getQuantity()
        {
            return $this->quantity;
        }

        public function setName($name)
        {
            $this->name = $name;
        }

        public function setSegment($segment)
        {
            $this->segment = $segment;
        }

        public function setPrice($price)
        {
            $this->price = $price;
        }

        public function setQuantity($quantity)
        {
            $this->quantity = $quantity;
        }

    /**
     * Add reservations
     *
     * @param \JProgramowania\ProjectBundle\Entity\Reservation $reservations
     * @return Car
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
     * @return Car
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
}