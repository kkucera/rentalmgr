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
use Core\DataTable\SearchCriteria as DataTableSearchCriteria;
use User\Entity\User as UserModel;
use User\Dto\SearchCriteria;
use User\Dao\Doctrine as UserDao;

class Service extends CrudServiceAbstract
{

    /**
     * @return UserDao
     */
    public function getDao()
    {
        return $this->getInstanceDao('User\Dao\Doctrine');
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

    /**
     * @param SearchCriteria $searchCriteria
     * @return null|UserModel[]
     */
    public function searchUsers(SearchCriteria $searchCriteria)
    {
        return $this->getDao()->search($searchCriteria);
    }

    /**
     * @param DataTableSearchCriteria $searchCriteria
     * @return null|Entity\User[]
     */
    public function getUserList(DataTableSearchCriteria $searchCriteria)
    {
        return $this->getDao()->getUserList($searchCriteria);
    }
}