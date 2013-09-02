<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/1/13
 */
namespace Property\Marshal;

use Application\Marshal\MarshallerAbstract;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Property\Dao\Doctrine as PropertyDao;
use Property\Entity\Property;

class ArrayToProperty extends MarshallerAbstract
{

    /**
     * @return Property
     */
    protected function getProperty()
    {
        return new Property();
    }

    /**
     * @return PropertyDao
     */
    protected function getPropertyDao()
    {
        return new PropertyDao();
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
     * @return Property
     */
    public function marshal($data)
    {
        $propertyDao = $this->getPropertyDao();

        $hydrator = $this->getDoctrineObject(
            $propertyDao->getEntityManager(),
            $propertyDao->getEntityName()
        );

        return $hydrator->hydrate($data, $this->getProperty());
    }

}