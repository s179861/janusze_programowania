<?php

namespace JProgramowania\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

use \Datetime;

use JProgramowania\ProjectBundle\Entity\Car;
use JProgramowania\ProjectBundle\Entity\Reservation;
use JProgramowania\ProjectBundle\Entity\Hire;
use JProgramowania\ProjectBundle\Entity\User;

use JProgramowania\ProjectBundle\Components\AvailableCarFinder;
use JProgramowania\ProjectBundle\Components\LoginLogoutButtonGenerator;

use JProgramowania\ProjectBundle\Form\LoginButtonForm;
use JProgramowania\ProjectBundle\Form\LogoutButtonForm;
use JProgramowania\ProjectBundle\Form\ReserveButtonForm;
use JProgramowania\ProjectBundle\Form\HireCarForm;
use JProgramowania\ProjectBundle\Form\HireButtonForm;

//-----
use JProgramowania\ProjectBundle\Components\DBDataGenerator;
//-----

class DefaultController extends Controller
{
    public function initializeDBAction()
	{
		$generator = new DBDataGenerator();
		$em = $this->getDoctrine()->getManager();
		$datetime = new Datetime();
				
		$generator->generate($em, $datetime);
		
		return $this->render('JProgramowaniaProjectBundle:Default:generowanie.html.twig');
	}

    public function testAction(Request $request)
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
		
		$loginlogout = LoginLogoutButtonGenerator::generateButton($this, new LoginButtonForm($this), new LogoutButtonForm($this));
		$login_message = LoginLogoutButtonGenerator::generateMessage($this);
		
		$reserve_button = $this->createForm(new ReserveButtonForm(1), array())->createView();
		
		$user = $this->get('security.context')->getToken()->getUser();
		if($user != 'anon.')
		{
			$zalogowany = 1;
		}
		else
		{
			$zalogowany = 0;
		}
		$values['value10'] = $zalogowany;
		return $this->render('JProgramowaniaProjectBundle:Default:test.html.twig',
			[
				'values' => $values,
				'login_logout_button' => $loginlogout->createView(),
				'login_logout_message' => $login_message,
				'reserve_button' => $reserve_button,
				'zalogowany' => $zalogowany
			]
		);
    }
	
	public function mainPageAction()
	{
		$user = $this->get('security.context')->getToken()->getUser();
		if($user != 'anon.')
		{
			$zalogowany = 1;
		}
		else
		{
			$zalogowany = 0;
		}
		$loginlogout = LoginLogoutButtonGenerator::generateButton($this, new LoginButtonForm($this), new LogoutButtonForm($this));
		$login_message = LoginLogoutButtonGenerator::generateMessage($this);
		
		return $this->render('JProgramowaniaProjectBundle:Default:main_page.html.twig',
			[
				'login_logout_button' => $loginlogout->createView(),
				'login_logout_message' => $login_message,
				'zalogowany' => $zalogowany
			]
		);
	}

    public function carsListAction()
    {
		$user = $this->get('security.context')->getToken()->getUser();
		if($user != 'anon.')
		{
			$zalogowany = 1;
		}
		else
		{
			$zalogowany = 0;
		}
		$loginlogout = LoginLogoutButtonGenerator::generateButton($this, new LoginButtonForm($this), new LogoutButtonForm($this));
		$login_message = LoginLogoutButtonGenerator::generateMessage($this);
		
        $datetime = new Datetime();

        $em = $this->getDoctrine()->getManager();
        $cars_array = $em->getRepository('JProgramowaniaProjectBundle:Car')->findIdsAndQuantitys();
        $hires_array = $em->getRepository('JProgramowaniaProjectBundle:Hire')->findActiveHiresQuantity($datetime);
        $repositories_array = $em->getRepository('JProgramowaniaProjectBundle:Reservation')->findActiveReservationsQuantity($datetime);

        $available_cars = AvailableCarFinder::getAvailableCarsIdList($cars_array, $hires_array, $repositories_array);
		
        $cars = $em->getRepository('JProgramowaniaProjectBundle:Car')->findAll();
		$cars_table = array(array());
		$counter = 0;
		foreach($cars as $car)
		{
			$cars_table[$counter]['car'] = $car;
			if(in_array($car->getId(), $available_cars))
			{
				$cars_table[$counter]['avaliablity'] = $this->createForm(new ReserveButtonForm($car->getId()), array())->createView();
			}
			else
			{
				$cars_table[$counter]['avaliablity'] = 'nie dostępny';
			}
			$counter++;
		}
		
        return $this->render('JProgramowaniaProjectBundle:Default:cars_list.html.twig',
            [
                'cars' => $cars_table,
				'available_cars' =>$available_cars,
				'zalogowany' => $zalogowany,
				'login_logout_button' => $loginlogout->createView(),
				'login_logout_message' => $login_message,
            ]
        );
    }
	
	public function doReservationAction(Request $request)
	{
		$user = $this->get('security.context')->getToken()->getUser();
		
		$form = $this->createForm(new ReserveButtonForm(0), array());
		if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
			$car_id = $data['car_id'];
        }
		$car = $this->getDoctrine()->getRepository('JProgramowaniaProjectBundle:Car')->find($car_id);
		
		$reservation = new Reservation(new Datetime(), 1, $car, $user);
		$em = $this->getDoctrine()->getManager();
		$em->persist($reservation);
		$em->flush();
		
		return new RedirectResponse('moje rezerwacje'); 
	}
	
	public function myReservationsAction(Request $request)
	{
		$user = $this->get('security.context')->getToken()->getUser();
		if($user != 'anon.')
		{
			$zalogowany = 1;
		}
		else
		{
			$zalogowany = 0;
		}
		$loginlogout = LoginLogoutButtonGenerator::generateButton($this, new LoginButtonForm($this), new LogoutButtonForm($this));
		$login_message = LoginLogoutButtonGenerator::generateMessage($this);
		
		$reservations = $user->getReservations();
		$reservations = $reservations->getValues();
		
		$reservations_table = array(array());
		$counter = 0;
		foreach($reservations as $reservation)
		{
			$car = $reservation->getCar();
			$reservations_table[$counter]['reservation'] = $reservation;
			$reservations_table[$counter]['car'] = $car;
			$reservations_table[$counter]['hire_form'] = $this->createForm(new HireCarForm($car->getId(), $reservation->getId()), array())->createView();
			$counter++;
		}
		
		return $this->render('JProgramowaniaProjectBundle:Default:user_reservations.html.twig',
            [
                'reservations' => $reservations_table,
				'zalogowany' => $zalogowany,
				'login_logout_button' => $loginlogout->createView(),
				'login_logout_message' => $login_message,
            ]
        );
	}
	
	public function myHiresAction(Request $request)
	{
		$user = $this->get('security.context')->getToken()->getUser();
		if($user != 'anon.')
		{
			$zalogowany = 1;
		}
		else
		{
			$zalogowany = 0;
		}
		$loginlogout = LoginLogoutButtonGenerator::generateButton($this, new LoginButtonForm($this), new LogoutButtonForm($this));
		$login_message = LoginLogoutButtonGenerator::generateMessage($this);
		
		$hires = $user->getHires();
		$hires = $hires->getValues();
		
		$hires_table = array(array());
		$counter = 0;
		foreach($hires as $hire)
		{
			$hire->getCar();
		}
		
		return $this->render('JProgramowaniaProjectBundle:Default:user_hires.html.twig',
            [
                'hires' => $hires,
				'zalogowany' => $zalogowany,
				'login_logout_button' => $loginlogout->createView(),
				'login_logout_message' => $login_message,
            ]
        );
	}
	
	public function doHireAction(Request $request)
	{
		$user = $this->get('security.context')->getToken()->getUser();
		if($user != 'anon.')
		{
			$zalogowany = 1;
		}
		else
		{
			$zalogowany = 0;
		}
		$loginlogout = LoginLogoutButtonGenerator::generateButton($this, new LoginButtonForm($this), new LogoutButtonForm($this));
		$login_message = LoginLogoutButtonGenerator::generateMessage($this);
		
		$form = $this->createForm(new HireCarForm(0, 0), array());
		if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
			$car_id = $data['car_id'];
			$reservation_id = $data['reservation_id'];
			$start_date = $data['start_date'];
			$days_quantity = $data['days'];
        }
		
		$data_array = array();
		
		$car = $this->getDoctrine()
        ->getRepository('JProgramowaniaProjectBundle:Car')
        ->find($car_id);
		$data_array['car'] = $car;
		
		$data_array['reservation_id'] = $reservation_id;
		$data_array['start_data'] = $start_date->format('Y-m-d H:i:s');
		$data_array['end_data'] = $start_date->modify('+'.$days_quantity.' days')->format('Y-m-d H:i:s');
		$data_array['days'] = $days_quantity;
		
		$discount = 0;
		if($days_quantity > 7) {
			$discount = 0.1;
		}
		
		$new_hires_quantity = 0;
		$hires = $user->getHires();
		$hires = $hires->getValues();
		foreach($hires as $hire)
		{
			$date = $hire->getStartDate();
			$date = $date->modify('+30 days');
			if($date > new Datetime())
			{
				$new_hires_quantity++;
			}
		}
		
		if($new_hires_quantity >= 3) {
			$discount = 0.2;
		}
		
		$price = $car->getPrice();
		$price = $price * $days_quantity;
		$discount_value = $price * $discount;
		$price = round($price - $discount_value,2);
		$data_array['price'] = $price;
		
		$confirm_button = $this->createForm(new HireButtonForm($car->getId(), $reservation_id, $user->getId(), $data_array['start_data'], $data_array['end_data'], $price), array());
		
		return $this->render('JProgramowaniaProjectBundle:Default:wyporzycz.html.twig',
            [
                'car' => $car,
				'user' => $user,
				'start_date' => $data_array['start_data'],
				'end_date' => $data_array['end_data'],
				'days_quantity' => $data_array['days'],
				'price' => $price,
				'reservation_id' => $reservation_id,
				'confirm_button' => $confirm_button->createView(),
				'zalogowany' => $zalogowany,
				'login_logout_button' => $loginlogout->createView(),
				'login_logout_message' => $login_message,
            ]
        );
	}
	
	public function startDotpayAction(Request $request)
	{
		$form = $this->createForm(new HireButtonForm(0, 0, 0, new Datetime(), new Datetime(), 0), array());
		if ($request->isMethod('POST')) {
            $form->bind($request);
            $data = $form->getData();
			$car_id = $data['car_id'];
			$reservation_id = $data['reservation_id'];
			$user_id = $data['user_id'];
			$start_date = $data['start_date'];
			$end_date = $data['end_date'];
			$price = $data['price'];
        }
		
		$user = $this->get('security.context')->getToken()->getUser();
		$user_id = $user->getId();
		$user_login = $user->getUsername();
		$user_firstname = $user->getFirstname();
		$user_lastname = $user->getLastname();
		$user_email = $user->getEmail();
		
		$response = $this->forward('JProgramowaniaProjectBundle:Default:confirmHire', array(
        'car_id'  => $car_id,
		'reservation_id'  => $reservation_id,
		'user_id' => $user_id,
		'start_date'  => $start_date,
		'end_date'  => $end_date,
		'price'  => $price,
		));

		return $response;
	}
	
	public function confirmHireAction($car_id, $reservation_id, $user_id, $start_date, $end_date, $price)
	{
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('JProgramowaniaProjectBundle:User')->find($user_id);
		$car = $em->getRepository('JProgramowaniaProjectBundle:Car')->find($car_id);
		$reservation = $em->getRepository('JProgramowaniaProjectBundle:Reservation')->find($reservation_id);
				
		if ($reservation) {
			$reservation->setIsActive(0);
		}
		$em->persist($reservation);
		
		$hire = new Hire(new Datetime($start_date), new Datetime($end_date), $price, $car, $user);
		
		$em->persist($hire);
		
		$em->flush();
		
		$mail_tresc = 'Dzień dobry, dokonano transakcji.<br/>';
		$mail_tresc .= 'Wyporzyczenie samochodu.<br/>';
		$mail_tresc .= 'Marka: '.$car->getName().'<br/>';
		$mail_tresc .= 'Data rozpoczęcia: '.$hire->getStartDate()->format('Y-m-d H:i:s').'<br/>';
		$mail_tresc .= 'Data zakończenia: '.$hire->getEndDate()->format('Y-m-d H:i:s').'<br/>';
		$mail_tresc .= 'Cena: '.$hire->getPrice();
		
		$url = 'https://mandrillapp.com/api/1.0/messages/send.json';
	        $params = [
	            'message' => array(
	                'subject' => 'Wypożyczenie samochodu',
	                'text' => $mail_tresc,
	                'html' => '<p>'.$mail_tresc.'</p>',
	                'from_email' => 'wyporzyczalnia@wyporzyczalnia.com',
	                'to' => array(
	                    array(
	                        'email' => $user->getEmail(),
	                        'name' => $user->getUsername()
	                    )
        	        )
        	    )
        	];
        	
		$params['key'] = 'HEpZLrPrRBEa7W9fLAJKeQ';
		$params = json_encode($params);
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		$head = curl_exec($ch); 
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		curl_close($ch); 
		
		return new RedirectResponse('../oferta');
	}
}
