<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/1/13
 */
namespace Expense\Marshal;

use Application\Marshal\MarshallerAbstract;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Books\Expense\Dao\Doctrine as ExpenseDao;
use Books\Entity\Expense;

class ArrayToExpense extends MarshallerAbstract
{

    /**
     * @return Expense
     */
    protected function getExpense()
    {
        return new Expense();
    }

    /**
     * @return ExpenseDao
     */
    protected function getExpenseDao()
    {
        return new ExpenseDao();
    }

    /**
     * @param $entityManager
     * @param $entityName
     * @return DoctrineObject
     */
    protected function getDoctrineObject($entityManager, $entityName)
    {
        return new DoctrineObject($entityManager, $entityName);
    }

    /**
     * @param $data
     * @return Expense
     */
    public function marshal($data)
    {
        $propertyDao = $this->getExpenseDao();

        $hydrator = $this->getDoctrineObject(
            $propertyDao->getEntityManager(),
            $propertyDao->getEntityName()
        );

        return $hydrator->hydrate($data, $this->getExpense());
    }

}