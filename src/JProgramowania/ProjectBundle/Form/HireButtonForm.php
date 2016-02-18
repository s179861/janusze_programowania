<?php

namespace JProgramowania\ProjectBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class HireButtonForm extends AbstractType
{
    private $car_id;
    private $reservation_id;
    private $user_id;
    private $start_date;
    private $end_date;
    private $price;

    public function __construct($car_id, $reservation_id, $user_id, $start_date, $end_date, $price)
    {
        $this->car_id = $car_id;
        $this->reservation_id = $reservation_id;
        $this->user_id = $user_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->price = $price;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAction('start dotpay');
        $builder->add('Płać','submit');
        $builder->add('car_id', 'hidden', array('data' => $this->car_id));
        $builder->add('reservation_id', 'hidden', array('data' => $this->reservation_id));
        $builder->add('user_id', 'hidden', array('data' => $this->user_id));
        $builder->add('start_date', 'hidden', array('data' => $this->start_date));
        $builder->add('end_date', 'hidden', array('data' => $this->end_date));
        $builder->add('price', 'hidden', array('data' => $this->price));
    }

    public function getName()
    {
        return 'confirmHire';
    }
}