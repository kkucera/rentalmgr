<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/1/13
 */

namespace User;

use Application\ServiceLocator;
use Application\CrudServiceAbstract;
use User\Entity\User as UserModel;

class Service extends CrudServiceAbstract
{

    /**
     * @return string
     */
    protected function getDaoClassName()
    {
        return 'User\Dao\Doctrine';
    }

    /**
     * @param $username
     * @return UserModel|null
     */
    public function getUserByUsername($username)
    {
        return $this->getDao()->getUserByEmail($username);
    }

    /**
     * @param string $password
     * @return string
     */
    public function encryptPassword($password)
    {
        return $password;
    }
}