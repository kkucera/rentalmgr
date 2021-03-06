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
use Acl\Dao\Doctrine\Group as GroupDao;

class Group extends CrudServiceAbstract
{
    /**
     * @return GroupDao
     */
    public function getDao()
    {
        return $this->getInstanceDao('Acl\Dao\Doctrine\Group');
    }
}