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

class UserPermission extends CrudServiceAbstract {

    /**
     * Absolute class name of Dao to use for crud operations
     * @return string
     */
    protected function getDaoClassName()
    {
        return 'Acl\Dao\Doctrine\UserPermission';
    }

    /**
     * @return \Acl\Dao\Doctrine\UserPermission
     */
    public function getDao()
    {
        return parent::getDao();
    }

    /**
     * @param $userId
     * @return \Acl\Entity\Permission[]
     */
    public function getPermissionsByUserId($userId)
    {
        return $this->getDao()->getPermissionsByUserId($userId);
    }

    /**
     * @param $userId
     * @return \int[]
     */
    public function getPermissionIdsForUserId($userId)
    {
        return $this->getDao()->getPermissionIdsForUserId($userId);
    }
}