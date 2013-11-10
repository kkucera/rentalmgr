<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/21/13
 */

namespace Acl\Dao\Doctrine;


use Application\Dao\DoctrineCrud;
use Acl\Entity\UserGroup as UserGroupEntity;

class UserGroup extends DoctrineCrud
{

    /**
     * This is the class name of the model this dao works with
     * @return string
     */
    public function getEntityName()
    {
        return 'Acl\Entity\UserGroup';
    }

    /**
     * @return UserGroupEntity[]
     */
    public function getList()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ug, g')
            ->from('Acl\Entity\UserGroup', 'ug')
            ->innerJoin('ug.group','g');

        $query = $qb->getQuery();
        return $query->execute();
    }

    /**
     * @param $userId
     * @return UserGroupEntity[]
     */
    public function getListByUserId($userId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ug, g')
            ->from('Acl\Entity\UserGroup', 'ug')
            ->innerJoin('ug.group','g')
            ->where('ug.userId = :userId')
            ->orderBy('g.name');

        $query = $qb->getQuery();
        return $query->execute(array('userId'=>$userId));
    }

    /**
     * @param $userId
     * @return UserGroupEntity[]
     */
    public function getGroupsWithResourcesByUserId($userId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ug, g, r')
            ->from('Acl\Entity\UserGroup', 'ug')
            ->innerJoin('ug.group','g')
            ->innerJoin('g.resources','r')
            ->where('ug.userId = :userId')
            ->orderBy('g.name');

        $query = $qb->getQuery();
        return $query->execute(array('userId'=>$userId));
    }

}