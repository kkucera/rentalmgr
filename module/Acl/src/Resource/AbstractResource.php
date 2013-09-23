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
use Acl\Entity\Permission;
use Acl\Exception\InvalidPermission;

abstract class AbstractResource {

    /**
     * @var ResourceEntity
     */
    private $entity;

    /**
     * @var Permission[]
     */
    private $permissions;

    /**
     * @param $id
     * @param $name
     * @param $description
     * @return $this
     */
    protected function addPermission($id, $name, $description)
    {
        $permission = new Permission();
        $permission
            ->setId($id)
            ->setName($name)
            ->setDescription($description)
            ->setResource($this->getEntity());
        $this->permissions[$name] = $permission;
        return $this;
    }

    public function __construct()
    {
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
     * @return Permission[]
     */
    public abstract function definePermissions();

    /**
     * @param $name
     * @return Permission
     * @throws \Acl\Exception\InvalidPermission
     */
    public function getPermission($name)
    {
        if(!isset($this->permissions[$name])){
            throw new InvalidPermission("Permission [$name] for resource [{$this->getName()}] does not exist.");
        }
        return $this->permissions[$name];
    }

    /**
     * @return \Acl\Entity\Permission[]
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
        if(empty($this->entity)){
            $this->entity = new ResourceEntity();
            $this->entity->setId($this->getId());
            $this->entity->setName($this->getName());
            $this->entity->setDescription($this->getDescription());
        }
        return $this->entity;
    }

}