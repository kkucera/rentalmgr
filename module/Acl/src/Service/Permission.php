<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/20/13
 *
 * This class should be used as a service and only one instance should exist.
 * It has not be setup as a singleton because I'm using is with Zend serviceLocator
 * Architecture which will maintain a single instance of the class for me.
 */

namespace Acl\Service;

use Acl\Dao\Doctrine\Permission as PermissionDao;
use Acl\Entity\Permission as PermissionEntity;
use Acl\Exception\PermissionDenied;
use Application\CrudServiceAbstract;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Permission extends CrudServiceAbstract implements ServiceLocatorAwareInterface
{

    /**
     * contains current user Id
     * @var int
     */
    private static $userId;

    /**
     * @var PermissionEntity[][]
     */
    private static $userPermissions;

    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return Permission
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @return \Acl\Service\UserPermission
     */
    protected function getUserPermissionService()
    {
        return $this->getServiceLocator()->get('Acl\Service\UserPermission');
    }

    /**
     * @return \Acl\Service\UserGroup
     */
    protected function getUserGroupService()
    {
        return $this->getServiceLocator()->get('Acl\Service\UserGroup');
    }

    /**
     * @return \Acl\Service\Resource
     */
    protected function getResourceService()
    {
        return $this->getServiceLocator()->get('Acl\Service\Resource');
    }

    /**
     * @param $userId
     * @return PermissionEntity[]
     */
    protected function getPermissionsByUserId($userId)
    {
        if(empty(self::$userPermissions[$userId])){
            self::$userPermissions[$userId] = $this->loadUserPermissions($userId);
        }
        return self::$userPermissions[$userId];
    }

    /**
     * @param $userId
     * @return array
     */
    protected function loadUserPermissions($userId)
    {
        $permissions = array();
        $permissionIds = $this->getDao()->getPermissionIdsForUserId($userId);
        foreach($permissionIds as $permissionId){
            $permissions[$permissionId] = true;
        }
        return $permissions;
    }

    /**
     * @return PermissionDao
     */
    public function getDao()
    {
        return parent::getDao();
    }

    /**
     * @param PermissionEntity $permission
     * @param $userId
     * @return bool
     */
    public function userHasPermission(PermissionEntity $permission, $userId = null)
    {
        return $this->userHasPermissionId($permission->getId(), $userId);
    }

    /**
     * @param $permissionId
     * @param null $userId
     * @return bool
     */
    public function userHasPermissionId($permissionId, $userId = null)
    {
        $userId = ($userId ?: $this->getUserId());
        $permissions = $this->getPermissionsByUserId($userId);
        if(isset($permissions[$permissionId])){
            return true;
        }
        return false;
    }

    /**
     * @param $permissionId
     * @param null $userId
     * @throws \Acl\Exception\PermissionDenied
     */
    public function requirePermissionId($permissionId, $userId = null)
    {
        if(!$this->userHasPermissionId($permissionId, $userId)){
            /** @var PermissionEntity $permission */
            $permission = $this->load($permissionId);
            $resource = $permission->getResource();
            throw new PermissionDenied('User does not have the required permission: ['.$resource->getName().' - '.$permission->getName().']');
        }
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return self::$userId;
    }

    /**
     * @param $userId
     */
    public function setUserId($userId)
    {
        self::$userId = $userId;
    }

    /**
     * Absolute class name of Dao to use for crud operations
     * @return string
     */
    protected function getDaoClassName()
    {
        return 'Acl\Dao\Doctrine\Permission';
    }

}