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
use Doctrine\ORM\Query\ResultSetMapping;

class Permission extends DoctrineCrud
{

    /**
     * This is the class name of the model this dao works with
     * @return string
     */
    public function getEntityName()
    {
        return 'Acl\Entity\Permission';
    }

    /**
     * @param $userId
     * @return int[]
     */
    public function getPermissionIdsForUserId($userId)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('permissionId', 'id');
        $query = $this->getEntityManager()->createNativeQuery('
            SELECT permissionId FROM acl_user_permission WHERE userId = :userId
            UNION
            SELECT permissionId FROM acl_group_permission
              INNER JOIN acl_user_group ON acl_user_group.groupId = acl_group_permission.groupId
                AND acl_user_group.userId = :userId
        ',$rsm);
        $results = $query->execute(array('userId'=>$userId));
        $permissionIds = array();
        foreach($results as $row){
            $permissionIds[] = $row['id'];
        }
        return $permissionIds;
    }

}