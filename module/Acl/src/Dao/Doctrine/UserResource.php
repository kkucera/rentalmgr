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
use Doctrine\ORM\Query\ResultSetMapping;

class UserResource extends DoctrineCrud
{

    /**
     * This is the class name of the model this dao works with
     * @return string
     */
    public function getEntityName()
    {
        return 'Acl\Entity\UserResource';
    }

    /**
     * @param $userId
     * @return ResourceEntity[]
     */
    public function getUserResourcesByUserId($userId)
    {
        return $this->getRepository()->findBy(array('userId'=>$userId));
    }

    /**
     * @param $userId
     * @return string[]
     */
    public function getResourceIdsByUserId($userId)
    {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('resourceId', 'resourceId');
        $query = $this->getEntityManager()->createNativeQuery('
            SELECT resourceId FROM acl_user_resource WHERE userId = :userId
            UNION
            SELECT resourceId FROM acl_group_resource
              INNER JOIN acl_user_group ON acl_user_group.groupId = acl_group_resource.groupId
                AND acl_user_group.userId = :userId
        ',$rsm);
        $results = $query->execute(array('userId'=>$userId));
        $resourceIds = array();
        foreach($results as $row){
            $resourceIds[] = $row['resourceId'];
        }
        return $resourceIds;
    }

}