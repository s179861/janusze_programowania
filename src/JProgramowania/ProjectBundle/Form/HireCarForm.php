<?php

namespace JProgramowania\ProjectBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use \Datetime;

class HireCarForm extends AbstractType
{
    private $car_id;
    private $reservation_id;

    public function __construct($car_id, $reservation_id)
    {
        $this->car_id = $car_id;
        $this->reservation_id = $reservation_id;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $current_date = new Datetime('now');
        $builder->setAction('../moje konto/wyporzycz');
        $builder->add('car_id', 'hidden', array('data' => $this->car_id));
        $builder->add('reservation_id', 'hidden', array('data' => $this->reservation_id));
        $builder->add('start_date', 'datetime', array('data' => new Datetime('now'), 'years' => range(date('Y'),date('Y')+1)));
        $builder->add('days','integer', array('data' => 1, 'label' => 'Ilość dni', 'attr' => array('min' => 1, 'max' => 30)));
        $builder->add('Potwierdź','submit');
    }

    public function getName()
    {
        return 'doHire';
    }
}