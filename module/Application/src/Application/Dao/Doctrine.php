<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/1/13
 */

namespace Application\Dao;

use Application\Dao\DoctrineFactory;
use Application\ServiceLocator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class Doctrine implements ServiceLocatorAwareInterface
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @return DoctrineFactory
     */
    protected function getDoctrineFactory()
    {
        return $this->getServiceLocator()->get('Application\Dao\DoctrineFactory');
    }

    /**
     * This is the class name of the model this dao works with
     * @return string
     */
    public abstract function getEntityName();

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getEntityManager()->getRepository($this->getEntityName());
    }

    /**
     * Returns the field name of the primary key for the model
     * @return string
     */
    protected function getSingleIdentifierFieldName() {
        $meta = $this->getEntityManager()->getClassMetadata($this->getEntityName());
        return $meta->getSingleIdentifierFieldName();
    }

    /**
     * @param EntityManager $em
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        if(empty($this->entityManager)){
            $factory = $this->getDoctrineFactory();
            $this->entityManager = $factory->getEntityManager();
        }
        return $this->entityManager;
    }

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
     * Flush the entity manager and write data to the database
     */
    public function flush()
    {
        $this->getEntityManager()->flush();
    }

}