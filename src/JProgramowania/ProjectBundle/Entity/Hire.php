<?php

    namespace JProgramowania\ProjectBundle\Entity;
    use Doctrine\ORM\Mapping as ORM;
    
    /**
     * @ORM\Entity(repositoryClass="JProgramowania\ProjectBundle\Entity\HireRepository")
     * @ORM\Table(name="hires")
     */
    class Hire
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
        private $start_date;
        /**
         * @ORM\Column(type="datetime")
         */
        private $end_date;
        /**
         * @ORM\ManyToOne(targetEntity="Car", inversedBy="hire")
         * @ORM\JoinColumn(name="car_id", referencedColumnName="id")
         */
        private $car;
		/**
         * @ORM\ManyToOne(targetEntity="User", inversedBy="hire")
         * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
         */
        private $user;

        public function __construct($start_date, $days, $car, $user)
        {
            $this->start_date = $start_date;
            $text_value = '+'.$days.' day';
            $this->end_date = clone $start_date;
            $this->end_date = $this->end_date->modify($text_value);
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

        public function getStartDate()
        {
            return $this->start_date;
        }

        public function getEndDate()
        {
            return $this->end_date;
        }

        public function setCar($car)
        {
            $this->car = $car;
        }

        public function setStartDate($start_date)
        {
            $this->start_date = $start_date;
        }

        public function setEndDate($end_date)
        {
            $this->end_date = $end_date;
        }
    
    /**
     * Set user
     *
     * @param \JProgramowania\ProjectBundle\Entity\User $user
     * @return Hire
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