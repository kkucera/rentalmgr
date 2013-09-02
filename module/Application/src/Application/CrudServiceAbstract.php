<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/1/13
 */

namespace Application;

use Application\Dao\DoctrineCrud;
use Application\ServiceLocator;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class CrudServiceAbstract implements ServiceLocatorAwareInterface
{

    /**
     * @var DoctrineCrud
     */
    private $dao;

    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * Absolute class name of Dao to use for crud operations
     * @return string
     */
    protected abstract function getDaoClassName();

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        if(empty($this->serviceLocator)){
            $this->serviceLocator = new ServiceLocator();
        }
        return $this->serviceLocator;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param DoctrineCrud $dao
     */
    public function setDao(DoctrineCrud $dao)
    {
        $this->dao = $dao;
    }

    /**
     * @return DoctrineCrud
     */
    public function getDao()
    {
        if(empty($this->dao)){
            $daoClass = $this->getDaoClassName();
            $this->dao = new $daoClass();
        }
        return $this->dao;
    }

    /**
     * Creates an entity.
     * @param object $entity
     * @return object
     */
    public function create($entity)
    {
        return $this->getDao()->create($entity);
    }

    /**
     * Delete an entity by id
     * @param $id
     * @return object
     */
    public function delete($id)
    {
        $entity = $this->getDao()->load($id);
        return $this->getDao()->delete($entity);
    }

    /**
     * @return \object[]
     */
    public function getList()
    {
        return $this->getDao()->getList();
    }

    /**
     * Loads an entity.
     * @param int $id
     * @return object
     */
    public function load($id)
    {
        return $this->getDao()->load($id);
    }

    /**
     * Updates an entity.
     * @param $entity
     * @return object
     */
    public function update($entity)
    {
        return $this->getDao()->update($entity);
    }

}