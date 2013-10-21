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

use Acl\Service\Permission as PermissionService;
use Acl\Service\Resource as ResourceService;
use Application\ServiceLocator;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\ServiceManager\ServiceLocatorInterface;

class ZendAcl extends Acl
{
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return ServiceLocator|ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        if(empty($this->serviceLocator)){
            $this->serviceLocator = new ServiceLocator();
        }
        return $this->serviceLocator;
    }

    /**
     * Creates a role for this userId and assigns it all the permissions that the user has access to.
     * Should be called once for each userId you wish to establish zend acl role / resources for.
     * @param $userId
     * @return $this
     */
    public function initAclForUser($userId)
    {
        $userRole = "user:$userId";
        $this->addRole(new GenericRole($userRole));

        $resources = $this->getResourceService()->getResourcesByUserId($userId);
        foreach($resources as $resource){
            $key = $resource->getResourceId();
            $this->addResource(new GenericResource($key));
            $this->allow($userRole, $key);
        }

        $permissions = $this->getPermissionsService()->getPermissionsByUserId($userId);
        foreach($permissions as $permissionId){
            $key = "permission:$permissionId";
            $this->addResource(new GenericResource($key));
            $this->allow($userRole, $key);
        }
        return $this;
    }

    /**
     * @return PermissionService
     */
    protected function getPermissionsService()
    {
        return $this->getServiceLocator()->get('Acl\Service\Permission');
    }

    /**
     * @return ResourceService
     */
    protected function getResourceService()
    {
        return $this->getServiceLocator()->get('Acl\Service\Resource');
    }

}