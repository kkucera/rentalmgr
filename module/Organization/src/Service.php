<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 11/24/13
 */

namespace Organization;


use Application\CrudServiceAbstract;
use Core\DataTable\SearchCriteria as DataTableSearchCriteria;
use Organization\Dao\Doctrine\Organization as OrganizationDao;

class Service extends CrudServiceAbstract
{

    /**
     * @return OrganizationDao
     */
    public function getDao()
    {
        return $this->getInstanceDao('Organization\Dao\Doctrine\Organization');
    }

    /**
     * @param DataTableSearchCriteria $searchCriteria
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getOrganizationList(DataTableSearchCriteria $searchCriteria)
    {
        return $this->getDao()->getOrganizationList($searchCriteria);
    }
}