<?php

namespace JProgramowania\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JProgramowania\ProjectBundle\Entity\Test;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JProgramowaniaProjectBundle:Default:index.html.twig', array('name' => $name));
    }
}
