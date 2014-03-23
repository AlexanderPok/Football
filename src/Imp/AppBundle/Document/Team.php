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
class Team
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @MongoDB\Date
     */
    private $dateCreated;

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     */
    private $coach;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Group", simple=true)
     */
    private $group;


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
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return self
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime $dateCreated
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set coach
     *
     * @param string $coach
     * @return self
     */
    public function setCoach($coach)
    {
        $this->coach = $coach;
        return $this;
    }

    /**
     * Get coach
     *
     * @return string $coach
     */
    public function getCoach()
    {
        return $this->coach;
    }

    /**
     * Set group
     *
     * @param \Imp\AppBundle\Document\Group $group
     * @return self
     */
    public function setGroup(\Imp\AppBundle\Document\Group $group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * Get group
     *
     * @return \Imp\AppBundle\Document\Group $group
     */
    public function getGroup()
    {
        return $this->group;
    }
}
