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
use Doctrine\ORM\Query\ResultSetMapping;

class Resource extends DoctrineCrud {

    /**
     * This is the class name of the model this dao works with
     * @return string
     */
    public function getEntityName()
    {
        return 'Acl\Entity\Resource';
    }

}