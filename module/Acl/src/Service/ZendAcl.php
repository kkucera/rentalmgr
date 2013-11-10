<?php
/**
 * This service registers the user's permissions as zend acl permission.
 * This class will work with other Zend features that support zend ACL.
 * To use it just get an instance of it through service locator then call initAclForUser.  This will create a zend acl
 * role for the provided userId and create zend acl permission for that role.
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/19/13
 */

namespace Acl\Service;

use Acl\Service\Interfaces\UserResourceServiceAwareInterface;
use Acl\Service\UserResource as UserResourceService;
use Application\ServiceLocator;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\ServiceManager\ServiceLocatorInterface;

class ZendAcl extends Acl implements UserResourceServiceAwareInterface
{

    /**
     * @var UserResourceService
     */
    private $userResourceService;

    /**
     * Creates a role for this userId and assigns it all the permissions that the user has access to.
     * Should be called once for each userId you wish to establish zend acl role / resources for.
     * @param $userId
     * @return $this
     */
    public function initAclForUser($userId)
    {
        $userRole = $this->getUserRole($userId);
        $this->addRole(new GenericRole($userRole));

        $resources = $this->getUserResourceService()->getResourceIdsByUserId($userId);
        foreach($resources as $resource){
            $this->addResource(new GenericResource($resource));
            $this->allow($userRole, $resource);
        }
        return $this;
    }

    /**
     * @param $userId
     * @return string
     */
    public function getUserRole($userId)
    {
        return "user:$userId";
    }

    /**
     * @param $userId
     * @param $resourceId
     * @return bool
     */
    public function userHasResource($userId, $resourceId)
    {
        return $this->isAllowed($this->getUserRole($userId), $resourceId);
    }

    /**
     * @return UserResourceService
     */
    public function getUserResourceService()
    {
        return $this->userResourceService;
    }

    /**
     * @param UserResourceService $service
     * @return mixed
     */
    public function setUserResourceService(UserResourceService $service)
    {
        $this->userResourceService = $service;
    }
}