<?php

namespace Imp\ParserBundle\Controller;

use Imp\ParserBundle\Service\Parser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Parse teams page http://worldcup2014.football.ua/groups/
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function teamsAction()
    {
        /** @var Parser $parserService */
        $parserService = $this->get('imp.parser.parser');
        $parserService->parseTeams();

        return $this->render('ImpParserBundle:Default:teams.html.twig');
    }
}
