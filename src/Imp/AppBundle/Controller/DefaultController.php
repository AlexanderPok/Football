<?php

namespace Imp\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ImpAppBundle:Default:index.html.twig');
    }
}
