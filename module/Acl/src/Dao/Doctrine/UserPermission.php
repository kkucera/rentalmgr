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
}