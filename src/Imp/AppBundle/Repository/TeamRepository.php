<?php
namespace Imp\AppBundle\Repository;

use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentRepository;

class TeamRepository extends DocumentRepository
{
    /**
     * @param array $names
     * @return Cursor
     */
    public function findByNames(array $names)
    {
        $qb = $this->createQueryBuilder()
            ->field('name')->in($names);

        return $qb->getQuery()->execute();
    }
}