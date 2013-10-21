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
use Acl\Entity\Resource as ResourceEntity;

class Resource extends DoctrineCrud {

    /**
     * This is the class name of the model this dao works with
     * @return string
     */
    public function getEntityName()
    {
        return 'Acl\Entity\Resource';
    }

    /**
     * @return Permission
     */
    protected function getPermissionDao()
    {
        return new Permission();
    }

    /**
     * Get an array of resource objects the user has access to.
     * @param $userId
     * @return ResourceEntity[]|null
     */
    public function getResourcesUserHasPermissionFor($userId)
    {
        $permissions = $this->getPermissionDao()->getPermissionIdsForUserId($userId);
        $permissionList = implode(',',$permissions);

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('resource');
        $qb->from($this->getEntityName(),'resource');
        $qb->innerJoin('Acl\Entity\Permission','permission','WITH','permission.resource=resource');
        $qb->where("permission.id IN ($permissionList)");
        $query = $qb->getQuery();

        return $query->execute();
    }

}