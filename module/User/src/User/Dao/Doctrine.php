<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/1/13
 */

namespace User\Dao;

use Application\Dao\DoctrineCrud as DoctrineCrud;
use User\Entity\User as UserModel;

class Doctrine extends DoctrineCrud
{

    /**
     * This is the class name of the model this dao works with
     * @return string
     */
    public function getEntityName()
    {
        return 'User\Entity\User';
    }

    /**
     * @param $username
     * @return UserModel|null
     */
    public function getUserByEmail($username)
    {
        return $this->getRepository()->findOneBy(array('email'=>$username));
    }

}