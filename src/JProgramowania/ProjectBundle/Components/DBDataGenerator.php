<?php

namespace JProgramowania\ProjectBundle\Components;    

use JProgramowania\ProjectBundle\Entity\Car;
use JProgramowania\ProjectBundle\Entity\Hire;
use JProgramowania\ProjectBundle\Entity\Reservation;
use JProgramowania\ProjectBundle\Entity\User;

class DBDataGenerator
{
	public function generate($em, $datetime)
	{
		$car[0] = new Car('Nazwa samochodu 1', 'Segment samochodu 1', 100.00, 5);
		$car[1] = new Car('Nazwa samochodu 2', 'Segment samochodu 2', 200.00, 10);
		
		$hire[0] = new Hire($datetime, 7, $car[0]);
		$hire[1] = new Hire($datetime, 7, $car[1]);
		$hire[2] = new Hire($datetime, 7, $car[0]);
		
		$reservation[0] = new Reservation($datetime, $car[0]);
		$reservation[1] = new Reservation($datetime, $car[0]);
		$reservation[2] = new Reservation($datetime, $car[1]);
		
		$user[0] = new User();
		$user[1] = new User();
		$user[2] = new User();
		
		$em->persist($car[0]);
		$em->persist($car[1]);
		
		$em->persist($hire[0]);
		$em->persist($hire[1]);
		$em->persist($hire[2]);
		
		$em->persist($reservation[0]);
		$em->persist($reservation[1]);
		$em->persist($reservation[2]);
		
		$em->flush();
	}
}
