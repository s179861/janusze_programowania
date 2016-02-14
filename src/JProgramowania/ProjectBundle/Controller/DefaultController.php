<?php

namespace JProgramowania\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use \Datetime;

use JProgramowania\ProjectBundle\Entity\Car;
use JProgramowania\ProjectBundle\Entity\Reservation;
use JProgramowania\ProjectBundle\Entity\Hire;

use JProgramowania\ProjectBundle\Components\AvailableCarFinder;

//-----
use JProgramowania\ProjectBundle\Components\DBDataGenerator;
//-----

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JProgramowaniaProjectBundle:Default:index.html.twig', array('name' => $name));
    }
	
	public function initializeDBAction()
	{
		$generator = new DBDataGenerator();
		$em = $this->getDoctrine()->getManager();
		$datetime = new Datetime();
				
		$generator->generate($em, $datetime);
		
		return $this->render('JProgramowaniaProjectBundle:Default:generowanie.html.twig');
	}

    public function testAction()
    {
        $values['value1'] = 1;
        $values['value2'] = 2;
        $values['value3'] = 3;
        $values['value4'] = 4;
        $values['value5'] = 5;
        $values['value6'] = 6;
        $values['value7'] = 7;
        $values['value8'] = 8;
        $values['value9'] = 9;
        $values['value10'] = 10;

        return $this->render('JProgramowaniaProjectBundle:Default:test.html.twig',
            [
                'values' => $values
            ]
        );
    }

    public function carsListAction()
    {
        $datetime = new Datetime();

        $em = $this->getDoctrine()->getManager();
        $cars_array = $em->getRepository('JProgramowaniaProjectBundle:Car')->findIdsAndQuantitys();
        $hires_array = $em->getRepository('JProgramowaniaProjectBundle:Hire')->findActiveHiresQuantity($datetime);
        $repositories_array = $em->getRepository('JProgramowaniaProjectBundle:Reservation')->findActiveReservationsQuantity($datetime);

        $available_cars = AvailableCarFinder::getAvailableCarsIdList($cars_array, $hires_array, $repositories_array);

        $cars = $em->getRepository('JProgramowaniaProjectBundle:Car')->findAll();

        return $this->render('JProgramowaniaProjectBundle:Default:cars_list.html.twig',
            [
                'cars' => $cars,
                'available_cars' => $available_cars
            ]
        );
    }
}
