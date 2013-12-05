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
use Core\Dao\Doctrine\Address as AddressDao;
use Core\Entity\Address as AddressEntity;

class Address extends CrudServiceAbstract
{
    /**
     * @return AddressEntity
     */
    public function getAddressEntity()
    {
        return new AddressEntity();
    }

    /**
     * @return AddressDao
     */
    public function getDao()
    {
        return $this->getInstanceDao('Core\Dao\Doctrine\Address');
    }
}