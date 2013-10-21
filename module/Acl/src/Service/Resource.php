<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/21/13
 */

namespace Acl\Service;

use Application\CrudServiceAbstract;
use Acl\Entity\Resource as ResourceEntity;
use Acl\Exception\RecursiveResourceRelationship;
use Acl\Resource\AbstractResource;

class Resource extends CrudServiceAbstract
{

    /**
     * Absolute class name of Dao to use for crud operations
     * @return string
     */
    protected function getDaoClassName()
    {
        return 'Acl\Dao\Doctrine\Resource';
    }

    /**
     * @param AbstractResource $resource
     * @param array $childIds
     * @throws \Acl\Exception\RecursiveResourceRelationship
     */
    public function initialize(AbstractResource $resource, $childIds=array())
    {
        //if this resource id is in it's own child chain then there is a recursive relationship happening to blowup.
        if(in_array($resource->getId(), $childIds)){
            throw new RecursiveResourceRelationship('Resource: '.$resource->getName().' is part of a recursive resource relationship.  Child ids: '. implode(',',$childIds));
        }
        $resourceEntity = $resource->getEntity();
        $parent = $resource->getParent();
        if($parent){
            // Add this id to the list of child ids.  This will be used to avoid recursion
            $childIds[] = $resource->getId();
            $this->initialize($parent, $childIds);
            $resourceEntity->setParent($parent->getEntity());
        }

        $this->save($resourceEntity);
    }

    /**
     * @return \Acl\Dao\Doctrine\Resource
     */
    public function getDao()
    {
        return parent::getDao();
    }

    /**
     * @return mixed
     */
    public function deleteAllResources()
    {
        return $this->getDao()->deleteAll();
    }

    /**
     * Returns an array of resources the user has access to.
     * @param $userId
     * @return AbstractResource[]|null
     */
    public function getResourcesByUserId($userId)
    {
        $resources = array();
        $directEntities = $this->getDao()->getResourcesUserHasPermissionFor($userId);
        $directResources = $this->convertEntitiesToResources($directEntities);
        foreach($directResources as $resource){
            $parents = $this->getResourceParents($resource);
            $resources = array_merge($resources, $parents);
            $resources[] = $resource;
        }
        return $resources;
    }

    /**
     * @param ResourceEntity[] $entities
     * @return AbstractResource[]
     */
    protected function convertEntitiesToResources($entities)
    {
        $resources = array();
        foreach($entities as $entity){
            $resourceClass = $entity->getClass();
            $resources[] = new $resourceClass;
        }
        return $resources;
    }

    /**
     * @param AbstractResource $resource
     * @param array $parents
     * @return array
     */
    protected function getResourceParents(AbstractResource $resource, $parents=array())
    {
        $parentResource = $resource->getParent();
        if($parentResource){
            $parents[] = $parentResource;
            $parents = $this->getResourceParents($parentResource, $parents);
        }
        return $parents;
    }
}