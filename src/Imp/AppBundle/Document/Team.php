<?php
namespace Imp\AppBundle\Document;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\Document(repositoryClass="Imp\AppBundle\Repository\TeamRepository")
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
     * @MongoDB\ReferenceMany(targetDocument="Group")
     *
     * @var ArrayCollection|Group[]
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
    public function __construct()
    {
        $this->group = new ArrayCollection();
    }
    
    /**
     * Add group
     *
     * @param Group $group
     */
    public function addGroup(\Imp\AppBundle\Document\Group $group)
    {
        $this->group[] = $group;
    }

    /**
     * Remove group
     *
     * @param Group $group
     */
    public function removeGroup(Group $group)
    {
        $this->group->removeElement($group);
    }

    /**
     * Get group
     *
     * @return Collection $group
     */
    public function getGroup()
    {
        return $this->group;
    }
}
