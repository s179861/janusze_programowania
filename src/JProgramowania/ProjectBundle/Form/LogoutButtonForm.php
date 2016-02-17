<?php

namespace JProgramowania\ProjectBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LogoutButtonForm extends AbstractType
{
    private $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAction($this->controller->generateUrl('logout'));
        $builder->add('Wyloguj','submit');
    }

    public function getName()
    {
        return 'logout';
    }
}