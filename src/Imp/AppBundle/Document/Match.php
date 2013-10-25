<?php
namespace Imp\AppBundle\Document;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\Document
 */
class Match
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Date
     */
    private $date;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Team")
     */
    private $firstTeam;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Team")
     */
    private $secondTeam;

    /**
     * @MongoDB\Int
     */
    private $firstTeamScore;

    /**
     * @MongoDB\Int
     */
    private $secondTeamScore;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set firstTeam
     *
     * @param \Imp\AppBundle\Document\Team $firstTeam
     * @return self
     */
    public function setFirstTeam(\Imp\AppBundle\Document\Team $firstTeam)
    {
        $this->firstTeam = $firstTeam;
        return $this;
    }

    /**
     * Get firstTeam
     *
     * @return \Imp\AppBundle\Document\Team $firstTeam
     */
    public function getFirstTeam()
    {
        return $this->firstTeam;
    }

    /**
     * Set secondTeam
     *
     * @param \Imp\AppBundle\Document\Team $secondTeam
     * @return self
     */
    public function setSecondTeam(\Imp\AppBundle\Document\Team $secondTeam)
    {
        $this->secondTeam = $secondTeam;
        return $this;
    }

    /**
     * Get secondTeam
     *
     * @return \Imp\AppBundle\Document\Team $secondTeam
     */
    public function getSecondTeam()
    {
        return $this->secondTeam;
    }

    /**
     * Set firstTeamScore
     *
     * @param int $firstTeamScore
     * @return self
     */
    public function setFirstTeamScore($firstTeamScore)
    {
        $this->firstTeamScore = $firstTeamScore;
        return $this;
    }

    /**
     * Get firstTeamScore
     *
     * @return int $firstTeamScore
     */
    public function getFirstTeamScore()
    {
        return $this->firstTeamScore;
    }

    /**
     * Set secondTeamScore
     *
     * @param int $secondTeamScore
     * @return self
     */
    public function setSecondTeamScore($secondTeamScore)
    {
        $this->secondTeamScore = $secondTeamScore;
        return $this;
    }

    /**
     * Get secondTeamScore
     *
     * @return int $secondTeamScore
     */
    public function getSecondTeamScore()
    {
        return $this->secondTeamScore;
    }
}
