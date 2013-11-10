<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/21/13
 */

namespace Acl\Service;

use Acl\Dao\Doctrine\UserResource as UserResourceDao;
use Acl\Entity\UserResource as UserResourceEntity;
use Acl\Service\Resource as ResourceService;
use Application\CrudServiceAbstract;

class UserResource extends CrudServiceAbstract
{

    /**
     * @var ResourceService
     */
    private $resourceService;

    /**
     * @param ResourceService $resourceService
     */
    public function __construct(ResourceService $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    /**
     * @return UserResourceEntity
     */
    public function getUserResourceEntity()
    {
        return new UserResourceEntity;
    }

    /**
     * @return UserResourceDao
     */
    public function getDao()
    {
        return $this->getInstanceDao('Acl\Dao\Doctrine\UserResource');
    }

    /**
     * @param $userId
     * @return UserResourceEntity[]
     */
    public function getUserResourcesByUserId($userId)
    {
        return $this->getDao()->getUserResourcesByUserId($userId);
    }

    /**
     * @param $userId
     * @return \string[]
     */
    public function getResourceIdsByUserId($userId)
    {
        return $this->getDao()->getResourceIdsByUserId($userId);
    }

    /**
     * @param $userId
     * @param $resourceNames
     */
    public function updateUserResources($userId, $resourceNames)
    {
        $currentResources = $this->getUserResourcesByUserId($userId);
        $indexedResources = $this->indexResources($currentResources);
        $currentResourceNames = array_keys($indexedResources);
        // add new Resources
        $newResourceNames = array_diff($resourceNames, $currentResourceNames);
        foreach($newResourceNames as $resourceName){
            $entity = $this->getUserResourceEntity();
            $entity->setUserId($userId);
            $resource = $this->resourceService->load($resourceName);
            $entity->setResource($resource);
            $this->save($entity);
        }
        // remove old Resources
        $removeResourceNames = array_diff($currentResourceNames, $resourceNames);
        foreach($removeResourceNames as $resourceName){
            $this->deleteEntity($indexedResources[$resourceName]);
        }
    }

    /**
     * @param UserResourceEntity[] $resources
     * @return array
     */
    protected function indexResources($resources){
        $indexed = array();
        foreach($resources as $resource){
            $indexed[$resource->getResource()->getId()] = $resource;
        }
        return $indexed;
    }
}