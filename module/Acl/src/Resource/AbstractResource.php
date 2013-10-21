<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/21/13
 */

namespace Acl\Resource;

use Acl\Entity\Resource as ResourceEntity;
use Acl\Exception\InvalidPermission;
use Acl\Resource\AbstractPermission;
use Application\ServiceLocator;
use Zend\Permissions\Acl\Resource\ResourceInterface;

abstract class AbstractResource implements ResourceInterface
{

    /**
     * @var ResourceEntity[]
     */
    private static $entities;

    /**
     * @var AbstractPermission[]
     */
    private $permissions;

    protected function addPermission(AbstractPermission $permission)
    {
        $this->permissions[] = $permission;
        return $this;
    }

    public function __construct()
    {
        $this->permissions = array();
        $this->definePermissions();
    }

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
     *
     */
    public abstract function definePermissions();

    /**
     * @return AbstractPermission[]
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param \Acl\Entity\Resource $entity
     * @return AbstractResource
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @return \Acl\Entity\Resource
     */
    public function getEntity()
    {
        $id = $this->getId();
        if(empty(self::$entities[$id])){
            $entity = new ResourceEntity();
            $entity->setId($this->getId());
            $entity->setName($this->getName());
            $entity->setDescription($this->getDescription());
            $entity->setClass(get_called_class());
            self::$entities[$id] = $entity;
        }
        return self::$entities[$id];
    }

    /**
     * Returns the string identifier of the Resource
     *
     * @return string
     */
    public function getResourceId(){
        return 'resource:'.$this->getId();
    }

    /**
     * Returns the parent resource
     * @return AbstractResource|null
     */
    public function getParent(){
        return null;
    }

}