<?php

namespace JProgramowania\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use \Datetime;

use JProgramowania\ProjectBundle\Entity\Car;
use JProgramowania\ProjectBundle\Entity\Reservation;
use JProgramowania\ProjectBundle\Entity\Hire;
use JProgramowania\ProjectBundle\Components\EnableCarFinder;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JProgramowaniaProjectBundle:Default:index.html.twig', array('name' => $name));
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

        return $this->render('JProgramowaniaProjectBundle:Default:test.html.twig', $values);
    }
}
