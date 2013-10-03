<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/28/13
 */

namespace Application\Marshal;

use Application\Exception\EntityNotSet;
use Application\Marshal\MarshallerAbstract;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Application\ServiceLocator;

abstract class EntityAbstract extends MarshallerAbstract
{
    /**
     * @var Object
     */
    private $entity;

    /**
     * @param null $entity
     */
    public function __construct($entity)
    {
        $this->setEntity($entity);
    }

    /**
     * @return Object
     * @throws \Application\Exception\EntityNotSet
     */
    public function getEntity()
    {
        if(empty($this->entity)){
            throw new EntityNotSet('Entity must be set prior to calling to trying to get or marshal.');
        }
        return $this->entity;
    }

    /**
     * @param $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        /** @var \Application\Dao\DoctrineFactory $doctrineFactory */
        $doctrineFactory = $this->getServiceLocator()->get('Application\Dao\DoctrineFactory');
        return $doctrineFactory->getEntityManager();
    }

    /**
     * @param $entityManager
     * @param $entityName
     * @return DoctrineObject
     */
    protected function getEntityHydrator($entityManager, $entityName)
    {
        return new EntityHydrator($entityManager, $entityName);
    }

}