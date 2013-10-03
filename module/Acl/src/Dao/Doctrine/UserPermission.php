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
use Doctrine\ORM\Query\ResultSetMapping;

class UserPermission extends DoctrineCrud
{

    /**
     * This is the class name of the model this dao works with
     * @return string
     */
    public function getEntityName()
    {
        return 'Acl\Entity\UserPermission';
    }

    /**
     * @param $userId
     * @return PermissionEntity[]
     */
    public function getPermissionsByUserId($userId)
    {
        return $this->getRepository()->findBy(array('userId'=>$userId));
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
            SELECT permissionId FROM acl_user_permission WHERE userId = :userId ORDER BY permissionId
        ',$rsm);
        $results = $query->execute(array('userId'=>$userId));
        $permissionIds = array();
        foreach($results as $row){
            $permissionIds[] = $row['id'];
        }
        return $permissionIds;
    }
}