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
use Core\DataTable\SearchCriteria as DataTableSearchCriteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
use User\Dto\SearchCriteria;
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

    /**
     * @param SearchCriteria $searchCriteria
     * @return UserModel[]|null
     */
    public function search(SearchCriteria $searchCriteria)
    {
        $where = array();
        $params = array();
        if($searchCriteria->getName()){
            $where[] = 'User.name LIKE :searchName';
            $params['searchName'] = '%'.$searchCriteria->getName().'%';
        }
        if($searchCriteria->getEmail()){
            $where[] = 'User.email LIKE :searchEmail';
            $params['searchEmail'] = '%'.$searchCriteria->getEmail().'%';
        }
        $dql = '
            SELECT User FROM
            '.$this->getEntityName().' as User
        ';
        if(!empty($where)){
            $dql.='WHERE '.implode(' AND ',$where);
        }

        $query = $this->getEntityManager()->createQuery($dql);
        return $query->execute($params);
    }

    /**
     * @param DataTableSearchCriteria $searchCriteria
     * @return Paginator
     */
    public function getUserList(DataTableSearchCriteria $searchCriteria)
    {

        $params = array(
            'searchName' => '%'.$searchCriteria->getSearchTerm().'%',
            'searchEmail' => '%'.$searchCriteria->getSearchTerm().'%',
        );

        $dql = '
            SELECT User FROM
            '.$this->getEntityName().' as User
            WHERE User.name LIKE :searchName
               OR User.email LIKE :searchEmail
        ';

        $query = $this->getEntityManager()->createQuery($dql)
            ->setFirstResult($searchCriteria->getStart())
            ->setMaxResults($searchCriteria->getLimit())
            ->setParameters($params);

        $paginator = new Paginator($query, $fetchJoinCollection = false);

        return $paginator;
    }

}