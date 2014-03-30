<?php
namespace Imp\ParserBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Guzzle\Service\Client;
use Imp\AppBundle\Document\Group;
use Imp\AppBundle\Document\Match;
use Imp\AppBundle\Document\Team;
use Imp\AppBundle\Repository\TeamRepository;
use Symfony\Component\DomCrawler\Crawler;

class Parser
{
    protected $guzzleClient;
    protected $om;
    /** @var TeamRepository */
    protected $teamRepo;


    /**
     * @param Client $guzzleClient
     * @param DocumentManager $om
     * @param DocumentRepository $teamRepository
     */
    public function __construct(
        Client $guzzleClient,
        DocumentManager $om,
        DocumentRepository $teamRepository
    ) {
        $this->guzzleClient = $guzzleClient;
        $this->om           = $om;
        $this->teamRepo     = $teamRepository;
    }

    /**
     * @param $url
     * @return \Guzzle\Http\EntityBodyInterface|string
     */
    public function getResponseBody($url)
    {
        $gc      = $this->guzzleClient;
        $request = $gc->get($url)->send();

        return $request->getBody(true);
    }

    /**
     * Parse teams by groups and include their matches
     */
    public function parseTeams()
    {
        $response = $this->getResponseBody('http://worldcup2014.football.ua/groups/');
        $om       = $this->om;
        $crawler  = new Crawler($response);
        /** @var Team[] $teams */
        $teams = $this->storeTeams($crawler);
        $this->storeMatches($crawler, $teams);
    }

    /**
     * @param Crawler $crawler
     * @return ArrayCollection|Team[]
     */
    public function storeTeams(Crawler $crawler)
    {
        $om = $this->om;
        $om->getDocumentCollection('ImpAppBundle:Team')->remove([]);
        $om->getDocumentCollection('ImpAppBundle:Group')->remove([]);

        $teamsArr = [];
        $crawler->filter('.groupsList li')->each(
            function (Crawler $node, $i) use ($crawler, $om, &$teamsArr) {
                $groupName = substr(trim($node->text()), -1);
                $group     = new Group();
                $group->setName($groupName);
                $om->persist($group);
                $teams = $this->getTeamsByGroupI($i, $crawler);
                foreach ($teams as $team) {
                    $team->addGroup($group);
                }
                $teamsArr = array_merge($teamsArr, $teams);
            }
        );

        $om->flush();

        return $teamsArr;
    }


    /**
     * @param $i
     * @param Crawler $crawler
     * @return array|Team[]
     */
    public function getTeamsByGroupI($i, Crawler $crawler)
    {
        $om       = $this->om;
        $teamsArr = [];
        $crawler->filter('.tabsList li.tab')
            ->eq($i)
            ->filter('td.team a')
            ->each(
                function (Crawler $node, $i) use ($om, &$teamsArr) {
                    $team                       = $this->getTeamByUrl($node->attr('href'));
                    $teamsArr[$team->getName()] = $team;
                    $om->persist($team);
                }
            );

        return $teamsArr;
    }

    /**
     * @param Crawler $crawler
     * @param ArrayCollection|Team[] $teams
     */
    public function storeMatches(Crawler $crawler, $teams)
    {
        $om = $this->om;
        $om->getDocumentCollection('ImpAppBundle:Match')->remove([]);

        $dateFormatter = new \IntlDateFormatter(
            'ru_RU',
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::NONE
        );
        $matchesArr    = new ArrayCollection();

        $crawler->filter('.matchBlock')->each(
            function (Crawler $node, $i) use ($dateFormatter, $matchesArr) {
                $date = new \DateTime();
                $date->setTimestamp(trim($dateFormatter->parse($node->filter('.matchHeader')->text())));

                $firstTeam       = trim($node->filter('.leftTeam')->text());
                $secondTeam      = trim($node->filter('.rightTeam')->text());
                $score           = explode('-', $node->filter('.scoreCell a')->text());
                $firstTeamScore  = $score[0];
                $secondTeamScore = $score[1];
                $matchesArr->add(
                    [
                        'date' => $date,
                        'firstTeam' => trim($firstTeam),
                        'secondTeam' => trim($secondTeam),
                        'firstTeamScore' => trim($firstTeamScore),
                        'secondTeamScore' => trim($secondTeamScore),
                    ]
                );
            }
        );

        foreach ($matchesArr as $matchArr) {
            $match = new Match();
            $match->setDate($matchArr['date'])
                ->setFirstTeam($teams[$matchArr['firstTeam']])
                ->setSecondTeam($teams[$matchArr['secondTeam']])
                ->setFirstTeamScore($matchArr['firstTeamScore'])
                ->setSecondTeamScore($matchArr['secondTeamScore']);
            $om->persist($match);
        }

        $om->flush();
    }

    /**
     * @param $url
     * @return Team
     */
    public function getTeamByUrl($url)
    {
        $response = $this->getResponseBody($url);
        $crawler  = new Crawler($response);
        $team     = new Team();
        $name     = trim($crawler->filter('.infoPageHeader')->text());
        $team->setName($name);
        $crawler->filter('.infoTable')->filter('tr')->each(
            function (Crawler $crawler, $i) use ($team) {
                $tds      = $crawler->filter('td');
                $infoName = mb_strtolower(trim($tds->first()->text()), 'UTF-8');
                switch ($infoName) {
                    case 'год основания:':
                        $team->setDateCreated(new \DateTime((int)$tds->last()->text()));
                        break;
                    case 'главный тренер:':
                        $team->setCoach($tds->last()->text());
                        break;
                }
            }
        );

        return $team;
    }
}