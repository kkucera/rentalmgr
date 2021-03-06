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
use Application\ServiceLocator;
use Zend\Permissions\Acl\Resource\ResourceInterface;

abstract class AbstractResource implements ResourceInterface
{
    // resources that are for system admins only not end users to assign
    const TYPE_SYSTEM = 1;
    // resources that are for end users to assign as long as they have the Acl manager role
    const TYPE_USER = 2;

    /**
     * @var ResourceEntity
     */
    private $entity;

    /**
     * @var AbstractResource
     */
    private $parent;

    /**
     * @var AbstractResource[]
     */
    private $children;

    /**
     * @var int
     */
    private $hierarchicalLevel;

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
     * Return the resource type.  By default a resource is an end user resource.
     * Over ride this to return TYPE_SYSTEM if this is a system ACL resource that should only be accessed by
     * system admins.
     * @return int
     */
    public function getType()
    {
        return self::TYPE_USER;
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
        $id = $this->getResourceId();
        if(empty($this->entity)){
            $entity = new ResourceEntity();
            $entity->setId($id);
            $entity->setName($this->getName());
            $entity->setDescription($this->getDescription());
            $entity->setType($this->getType());
            $parent = $this->getParent();
            if($parent){
                $entity->setParent($parent->getResourceId());
            }
            $this->entity = $entity;
        }
        return $this->entity;
    }

    /**
     * Returns the string identifier of the Resource
     *
     * @return string
     */
    public function getResourceId(){
        return str_replace('\\','-',get_called_class());
    }

    /**
     * Returns the parent resource
     * @return AbstractResource|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param AbstractResource $resource
     */
    public function setParent(AbstractResource $resource)
    {
        $this->parent = $resource;
    }

    /**
     * @param AbstractResource $resource
     */
    public function addChild(AbstractResource $resource)
    {
        $this->children[] = $resource;
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        return !empty($this->children);
    }

    /**
     * @return AbstractResource[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param $resources
     */
    public function setChildren($resources)
    {
        $this->children = $resources;
    }

    /**
     * @param int $hierarchicalLevel
     * @return AbstractResource
     */
    public function setHierarchicalLevel($hierarchicalLevel)
    {
        $this->hierarchicalLevel = $hierarchicalLevel;
        return $this;
    }

    /**
     * @return int
     */
    public function getHierarchicalLevel()
    {
        return $this->hierarchicalLevel;
    }

}