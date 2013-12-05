<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 11/30/13
 */

namespace Core\Service;

use Application\CrudServiceAbstract;
use Core\Dao\Doctrine\Phone as PhoneDao;
use Core\Entity\Phone as PhoneEntity;

class Phone extends CrudServiceAbstract
{
    /**
     * @return PhoneEntity
     */
    public function getPhoneEntity()
    {
        return new PhoneEntity();
    }

    /**
     * @return PhoneDao
     */
    public function getDao()
    {
        return $this->getInstanceDao('Core\Dao\Doctrine\Phone');
    }
}