<?php
namespace Imp\AppBundle\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GroupController extends Controller
{
    public function listAction()
    {
        $dm = $this->getOdm();
        $groups = $dm->getRepository('ImpAppBundle:Group')->findAll();
        return $this->render('ImpAppBundle:Group:list.html.twig', array('groups' => $groups));
    }

    /**
     * @return DocumentManager
     */
    protected function getOdm()
    {
        return $this->get('doctrine_mongodb');
    }
}