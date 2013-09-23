<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/21/13
 */

namespace Acl\Controller\Console;

use Acl\Resource\AbstractResource;
use Application\Controller\AbstractConsoleController;
use RuntimeException;

class ResourceController extends AbstractConsoleController
{

    /**
     * @return \Acl\Service\Resource
     */
    protected function getResourceService()
    {
        return $this->getServiceLocator()->get('Acl\Service\Resource');
    }

    /**
     * @return \Acl\Service\Permission
     */
    protected function getPermissionService()
    {
        return $this->getServiceLocator()->get('Acl\Service\Permission');
    }

    /**
     * @return string[]
     */
    protected function getRegisteredResources()
    {
        $config = $this->getServiceLocator()->get('config');
        return $config['acl-resource'];
    }

    /**
     * Validate that all resources that are registered in the config match a valid class and have unique ids.
     * @param $resourceClassNames
     * @return AbstractResource[]
     * @throws \RuntimeException
     */
    protected function validateResources($resourceClassNames)
    {
        $resourceIndex = array();
        $permissionIndex = array();
        $invalidResourceClassName = array();
        $invalidResourceClass = array();
        $duplicateResourceIds = array();
        $duplicatePermissionIds = array();
        $invalidResourceFound = false;
        $resources = array();
        foreach($resourceClassNames as $resourceName){
            if(!class_exists($resourceName)){
                $invalidResourceClassName[] = $resourceName;
                $invalidResourceFound = true;
                continue;
            }
            /** @var AbstractResource $resource */
            $resource = new $resourceName();
            if(!$resource instanceof \Acl\Resource\AbstractResource){
                $invalidResourceClass[] = $resourceName;
                $invalidResourceFound = true;
                continue;
            }
            if(empty($resourceIndex[$resource->getId()])){
                $resourceIndex[$resource->getId()] = array();
            }
            $resourceIndex[$resource->getId()][] = get_class($resource);

            foreach($resource->getPermissions() as $permission){
                if(empty($permissionIndex[$permission->getId()])){
                    $permissionIndex[$permission->getId()] = array();
                }
                $permissionIndex[$permission->getId()][] = get_class($resource);
            }

            $resources[] = $resource;
        }

        //check for duplicate resource ids
        foreach($resourceIndex as $id=>$resourcesWithId){
            if(count($resourcesWithId)>1){
                $duplicateResourceIds[$id] = $resourcesWithId;
                $invalidResourceFound = true;
            }
        }

        //check for duplicate resource ids
        foreach($permissionIndex as $id=>$resourcesWithId){
            if(count($resourcesWithId)>1){
                $duplicatePermissionIds[$id] = $resourcesWithId;
                $invalidResourceFound = true;
            }
        }

        if($invalidResourceFound){
            $message = PHP_EOL;
            if(!empty($invalidResourceClassName)){
                $message.=PHP_EOL.'The following resource names are registered in a config but do not point to a valid class:';
                $message.=PHP_EOL.' - '.implode(PHP_EOL.' - ',$invalidResourceClassName);
            }
            if(!empty($invalidResourceClass)){
                $message.=PHP_EOL.'The following resource classes are registered but must extend base class \Acl\Resource\AbstractResource:';
                $message.=PHP_EOL.' - '.implode(PHP_EOL.' - ',$invalidResourceClassName);
            }
            if(!empty($duplicateResourceIds)){
                $message.=PHP_EOL.'The following resources share the same resource id:';
                foreach($duplicateResourceIds as $id=>$resourceNames){
                    $message.=PHP_EOL.' - Resource Id: '.$id;
                    foreach($resourceNames as $name){
                        $message.=PHP_EOL.'   - '.$name;
                    }
                }
            }
            if(!empty($duplicatePermissionIds)){
                $message.=PHP_EOL.'The following resources share the same permission id:';
                foreach($duplicatePermissionIds as $id=>$resourceNames){
                    $message.=PHP_EOL.' - Permission Id: '.$id;
                    foreach($resourceNames as $name){
                        $message.=PHP_EOL.'   - '.$name;
                    }
                }
            }
            throw new RuntimeException($message);
        }
        return $resources;
    }

    /**
     *
     */
    public function registerResourcesAction()
    {
        $resourceNames = $this->getRegisteredResources();
        $resources = $this->validateResources($resourceNames);
        $resourceService = $this->getResourceService();
        $resourceService->deleteAllResources();
        foreach($resources as $resource){
            $resourceService->save($resource);

            $permissions = $resource->getPermissions();
            $permissionService = $this->getPermissionService();
            foreach($permissions as $permission){
                $permissionService->save($permission);
            }
        }
    }

}