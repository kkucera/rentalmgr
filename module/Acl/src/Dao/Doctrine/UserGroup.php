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
use Acl\Entity\Permission as PermissionEntity;

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
     * @param $userId
     * @return PermissionEntity[]
     */
    public function getPermissionsByUserId($userId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
//        $qb->select('g, p')
//           ->from('Acl\Entity\Group', 'g')
//           ->innerJoin('Acl\Entity\UserGroup','ug','WITH','ug.group = g')
//           ->innerJoin('g.permissions','p')
//           ->where('ug.userId = :userId');
        $qb->select('p')
           ->from('Acl\Entity\Permission', 'p')
           ->innerJoin('Acl\Entity\Group','g','ON','g.permissions = p')
           ->innerJoin('Acl\Entity\UserGroup','ug','WITH','ug.group = g')
           ->where('ug.userId = :userId');

        $query = $qb->getQuery();
        return $query->execute(array('userId'=>$userId));
    }
}