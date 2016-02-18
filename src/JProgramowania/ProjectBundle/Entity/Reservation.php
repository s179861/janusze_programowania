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

    public function getEndDate()
    {
        return $this->end_date;
    }

    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

    public function getIsActive()
    {
        return $this->is_active;
    }

    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;
        return $this;
    }

    public function getCar()
    {
        return $this->car;
    }

    public function setCar($car)
    {
        $this->car = $car;
    }

    public function setUser(\JProgramowania\ProjectBundle\Entity\User $user = null)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }
}