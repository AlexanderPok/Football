<?php

namespace Imp\ParserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ImpParserBundle:Default:index.html.twig', array('name' => $name));
    }
}
