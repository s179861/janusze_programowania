<?php

namespace JProgramowania\ProjectBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ReserveButtonForm extends AbstractType
{
    private $car_id;

    public function __construct($car_id)
    {
        $this->car_id = $car_id;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAction('moje konto/zrob rezerwacje');
        $builder->add('Zarezerwuj','submit');
        $builder->add('car_id', 'hidden', array('data' => $this->car_id));
    }

    public function getName()
    {
        return 'doReservation';
    }
}
