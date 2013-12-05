<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 11/30/13
 */

namespace Core\Dao\Doctrine;

use Application\Dao\DoctrineCrud;

class Address extends DoctrineCrud
{

    /**
     * This is the class name of the model this dao works with
     * @return string
     */
    public function getEntityName()
    {
        return 'Core\Entity\Address';
    }
}