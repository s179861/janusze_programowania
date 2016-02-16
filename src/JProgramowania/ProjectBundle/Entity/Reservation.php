<?php

    namespace JProgramowania\ProjectBundle\Entity;
    use Doctrine\ORM\Mapping as ORM;
    
    /**
     * @ORM\Entity(repositoryClass="JProgramowania\ProjectBundle\Entity\ReservationRepository")
     * @ORM\Table(name="reservations")
     */
    class Reservation
    {
        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        private $id;
        /**
         * @ORM\Column(type="datetime")
         */
        private $end_date;
		/**
         * @ORM\Column(name="is_active", type="boolean")
         */
		private $is_active;
		/**
         * @ORM\ManyToOne(targetEntity="Car", inversedBy="reservation")
         * @ORM\JoinColumn(name="car_id", referencedColumnName="id")
         */
        private $car;
		/**
         * @ORM\ManyToOne(targetEntity="User", inversedBy="reservation")
         * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
         */
        private $user;

        public function __construct($start_date, $is_active, $car, $user)
        {
            $this->end_date = clone $start_date;
            $this->end_date = $this->end_date->modify('+3 minute');
			$this->is_active = $is_active;
            $this->car = $car;
			$this->user = $user;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getCar()
        {
            return $this->car;
        }

        public function getEndDate()
        {
            return $this->end_date;
        }

        public function setCar($car)
        {
            $this->car = $car;
        }

        public function setEndDate($end_date)
        {
            $this->end_date = $end_date;
        }
    
    /**
     * Set is_active
     *
     * @param boolean $isActive
     * @return Reservation
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;
    
        return $this;
    }

    /**
     * Get is_active
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set user
     *
     * @param \JProgramowania\ProjectBundle\Entity\User $user
     * @return Reservation
     */
    public function setUser(\JProgramowania\ProjectBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \JProgramowania\ProjectBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}