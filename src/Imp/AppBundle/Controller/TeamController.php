<?php
namespace Imp\AppBundle\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TeamController extends Controller
{
    public function listAction()
    {
        $dm = $this->getOdm();
        $teams = $dm->getRepository('ImpAppBundle:Team')->findAll();
        return $this->render('ImpAppBundle:Team:list.html.twig', array('teams' => $teams));
    }

    /**
     * @return DocumentManager
     */
    protected function getOdm()
    {
        return $this->get('doctrine_mongodb');
    }
}