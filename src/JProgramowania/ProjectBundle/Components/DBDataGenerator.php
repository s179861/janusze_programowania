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
		$car[0] = new Car('Citroen', 'A', 100.00, 20);
		$car[1] = new Car('Ford', 'B', 200.00, 10);
		$car[2] = new Car('BMW', 'C', 300.00, 10);
		$car[3] = new Car('Nissan', 'D', 400.00, 5);
		$car[4] = new Car('Kia', 'E', 500.00, 2);
		$car[5] = new Car('Peugeot', 'F', 1000.00, 1);
		
		$user[0] = new User('klient1','klient1','klient1@klient.com', 'Adam', 'Adamski');
		$user[1] = new User('klient2','klient2','klient2@klient.com', 'Anna', 'Annowska');
		$user[2] = new User('klient3','klient3','klient3@klient.com', 'Andrzej', 'Andrzejny');
		
		$em->persist($car[0]);
		$em->persist($car[1]);
		$em->persist($car[2]);
		$em->persist($car[3]);
		$em->persist($car[4]);
		$em->persist($car[5]);
		$em->flush();
		
		$em->persist($user[0]);
		$em->persist($user[1]);
		$em->persist($user[2]);
		$em->flush();
	}
}
