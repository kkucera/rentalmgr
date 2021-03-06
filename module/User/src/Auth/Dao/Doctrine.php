<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/8/13
 */

namespace Auth\Dao;

use Application\Dao\DoctrineCrud as DoctrineCrud;

class Doctrine extends DoctrineCrud
{

    /**
     * This is the class name of the model this dao works with
     * @return string
     */
    public function getEntityName()
    {
        return 'Auth\Entity\Authentication';
    }

    public function removeOldAuthentications($maxLifeTime)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->delete($this->getEntityName(), 's')
            ->where($qb->expr()->lt('s.lastModified + '.$maxLifeTime, ':expires'))
            ->setParameter('expires', new \DateTime(), \Doctrine\DBAL\Types\Type::DATETIME)
            ->getQuery()
            ->execute();
    }

}