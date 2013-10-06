<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/28/13
 */

namespace Application\Hydrator;

use Application\Dao\DoctrineFactory;
use Application\Hydrator\Strategy\DatetimeToString;
use Application\Hydrator\Strategy\DoctrineEntity;
use Application\ServiceLocator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use DoctrineModule\Stdlib\Hydrator\Strategy\AllowRemoveByValue;
use DoctrineModule\Stdlib\Hydrator\Strategy\AllowRemoveByReference;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Entity extends DoctrineObject implements ServiceLocatorAwareInterface
{

    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @param string|object $entity
     */
    public function __construct($entity)
    {
        $entityManager = $this->getDoctrineFactory()->getEntityManager();
        $entityName = is_object($entity) ? get_class($entity) : $entity;
        parent::__construct(
            $entityManager, $entityName
        );
    }

    /**
     * @return DoctrineFactory
     */
    protected function getDoctrineFactory()
    {
        return $this->getServiceLocator()->get('Application\Dao\DoctrineFactory');
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
     * Prepare the hydrator by adding strategies to every collection valued associations
     *
     * @return void
     */
    protected function prepare()
    {
        $metadata = $this->metadata;

        $fieldNames = $metadata->getFieldNames();
        foreach ($fieldNames as $fieldName) {
            $type = $metadata->getTypeOfField($fieldName);
            if ($type === 'datetime') {
                $this->addStrategy($fieldName, new DatetimeToString());
            }
        }

        $associations = $metadata->getAssociationNames();
        foreach ($associations as $association) {
            // We only need to prepare collection valued associations
            if ($metadata->isCollectionValuedAssociation($association)) {
                if ($this->byValue) {
                    $this->addStrategy($association, new AllowRemoveByValue());
                } else {
                    $this->addStrategy($association, new AllowRemoveByReference());
                }
            }else{
                //echo ' association name: '.$association;
                $this->addStrategy($association, new DoctrineEntity());
            }
        }
    }

    /**
     * @param $entities
     * @return array - array of doctrine entities
     */
    public function extractAll($entities)
    {
        $arrays = array();
        foreach($entities as $entity)
        {
            $arrays[] = $this->extract($entity);
        }
        return $arrays;
    }

}