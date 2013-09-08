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

}