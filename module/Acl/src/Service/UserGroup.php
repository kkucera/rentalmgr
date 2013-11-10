<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/21/13
 */

namespace Acl\Service;

use Application\CrudServiceAbstract;
use Acl\Dao\Doctrine\UserGroup as UserGroupDao;

class UserGroup extends CrudServiceAbstract
{

    /**
     * @return UserGroupDao
     */
    public function getDao()
    {
        return $this->getInstanceDao('Acl\Dao\Doctrine\UserGroup');
    }

    /**
     * @param $userId
     * @return \Acl\Entity\UserGroup[]
     */
    public function getGroupsByUserId($userId)
    {
        return $this->getDao()->getListByUserId($userId);
    }

    /**
     * @param $userId
     * @return \Acl\Entity\UserGroup[]
     */
    public function getGroupsWithResourcesByUserId($userId)
    {
        return $this->getDao()->getGroupsWithResourcesByUserId($userId);
    }

}