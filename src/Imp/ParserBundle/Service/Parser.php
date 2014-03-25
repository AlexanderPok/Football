<?php
namespace Imp\ParserBundle\Service;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Guzzle\Service\Client;
use Imp\AppBundle\Document\Team;
use Symfony\Component\DomCrawler\Crawler;

class Parser
{
    protected $guzzleClient;
    protected $om;
    protected $teamRepo;


    public function __construct(Client $guzzleClient, DocumentManager $om, DocumentRepository $teamRepository)
    {
        $this->guzzleClient = $guzzleClient;
        $this->om           = $om;
        $this->teamRepo     = $teamRepository;
    }

    public function getResponseBody($url)
    {
        $gc = $this->guzzleClient;
        $request = $gc->get($url)->send();
        return $request->getBody(true);
    }

    public function parseTeams()
    {
        $response    = $this->getResponseBody('http://worldcup2014.football.ua/teams/');
        $om          = $this->om;
        $crawler     = new Crawler($response);
        /** @var Team[] $teams */
        $teams       = $this->teamRepo->findAll();
        $newTeamsArr = [];

        $crawler->filter('.teams .rowBlock.columnBlock')->each(function(Crawler $node, $i) use (&$newTeamsArr) {
            $team          = [];
            $team['name']  = $node->filter('.rowBlockName')->text();
            $team['coach'] = $node->filter('tr')->last()->filter('td')->last()->text();

            $year = $node->filter('tr')->first()->filter('td')->last()->text();
            if ((int)$year) {
                $team['year'] = new \DateTime($year);
            }
            $newTeamsArr[$team['name']] = $team;
        });

        // Clean up already imported teams
        foreach ($teams as $team) {
            if (isset($newTeamsArr[$team->getName()])) {
                unset($newTeamsArr[$team->getName()]);
            }
        }

        foreach ($newTeamsArr as $newTeam) {
            $team = new Team();
            $team ->setName($newTeam['name'])
                ->setCoach($newTeam['coach']);
            if (isset($newTeam['year'])) {
                $team ->setDateCreated($newTeam['year']);
            }
            $om->persist($team);
        }
        $om->flush();
    }
}