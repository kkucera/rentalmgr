<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/19/13
 */

namespace Acl\Resource;

use Acl\Entity\Permission as PermissionEntity;
use Zend\Permissions\Acl\Resource\ResourceInterface;

abstract class AbstractPermission implements ResourceInterface
{

    /**
     * @var PermissionEntity[]
     */
    private static $entities;

    /**
     * @var AbstractResource
     */
    private $resource;

    /**
     * Return the integer id for this resource.  This should be a unique number across all resources you will
     * use in the application.
     * @return int
     */
    public abstract function getId();

    /**
     * Return the name of this resource
     * @return string
     */
    public abstract function getName();

    /**
     * Return the description of this resource
     * @return string
     */
    public abstract function getDescription();

    /**
     * @return AbstractResource
     */
    public abstract function getParentResource();

    /**
     * @return PermissionEntity
     */
    public function getEntity()
    {
        $id = $this->getId();
        if(empty(self::$entities[$id])){
            $entity = new PermissionEntity();
            $entity->setId($this->getId());
            $entity->setName($this->getName());
            $entity->setDescription($this->getDescription());
            $entity->setResource($this->getParentResource()->getEntity());
            self::$entities[$id] = $entity;
        }
        return self::$entities[$id];
    }

    /**
     * Returns the string identifier of the Permission
     *
     * @return string
     */
    public function getResourceId(){
        return 'permission:'.$this->getId();
    }

}