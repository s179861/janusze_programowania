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
         * @ORM\ManyToOne(targetEntity="Car", inversedBy="reservation")
         * @ORM\JoinColumn(name="car_id", referencedColumnName="id")
         */
        private $car;

        public function __construct($start_date, $car)
        {
            $this->end_date = clone $start_date;
            $this->end_date = $this->end_date->modify('+3 minute');
            $this->car = $car;
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
    }