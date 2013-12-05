<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 11/24/13
 */

namespace Organization\Dao\Doctrine;

use Application\Dao\DoctrineCrud;
use Core\DataTable\SearchCriteria as DataTableSearchCriteria;
use Doctrine\ORM\Tools\Pagination\Paginator;

class Organization extends DoctrineCrud
{

    /**
     * This is the class name of the model this dao works with
     * @return string
     */
    public function getEntityName()
    {
        return 'Organization\Entity\Organization';
    }

    /**
     * @param DataTableSearchCriteria $searchCriteria
     * @return Paginator
     */
    public function getOrganizationList(DataTableSearchCriteria $searchCriteria)
    {

        $params = array(
            'searchName' => '%'.$searchCriteria->getSearchTerm().'%',
        );

        $dql = '
            SELECT Organization FROM
            '.$this->getEntityName().' as Organization
            WHERE Organization.name LIKE :searchName
        ';

        $query = $this->getEntityManager()->createQuery($dql)
            ->setFirstResult($searchCriteria->getStart())
            ->setMaxResults($searchCriteria->getLimit())
            ->setParameters($params);

        $paginator = new Paginator($query, $fetchJoinCollection = false);

        return $paginator;
    }
}