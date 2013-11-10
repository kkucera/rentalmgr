<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/26/13
 */

namespace Acl\Resource;

use Acl\Exception\InvalidResourceName;
use Acl\Exception\InvalidResourceRelationship;
use Acl\Resource\AbstractResource;
use Zend\ServiceManager\ServiceLocatorInterface;

class Factory
{

    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @var string[]
     */
    private $resourceNames;

    /**
     * @var AbstractResource[]
     */
    private $resources;

    /**
     * @var AbstractResource[]
     */
    private $topResources;

    /**
     * @param $resources
     * @param AbstractResource $parent
     * @param int $level
     */
    protected function initializeResources($resources, $parent=null, $level=0)
    {
        foreach($resources as $key=>$value){
            if(is_string($key)){
                $resource = $this->initializeResource($key, $parent, $level);
                if(is_array($value)){
                    $this->initializeResources($value, $resource, $level+1);
                }
            }else{
                $resource = $this->initializeResource($value, $parent, $level);
            }
            if($level===0){
                $this->topResources[] = $resource;
            }
        }
    }

    /**
     * @param $resourceName
     * @param AbstractResource $parent
     * @param $level
     * @return AbstractResource
     * @throws InvalidResourceRelationship
     * @throws InvalidResourceName
     */
    protected function initializeResource($resourceClassName, $parent=null, $level)
    {
        if(!class_exists($resourceClassName)){
            throw new InvalidResourceName('Resource ['.$resourceClassName.'] does not exist');
        }
        /** @var AbstractResource $resource */
        $resource = new $resourceClassName;
        if(!$resource instanceof AbstractResource){
            throw new InvalidResourceName('Resource ['.$resourceClassName.'] points to a class that is not a valid AbstractResource.');
        }
        // if this resource has already be initialized as part of another relationship then blowup.  Resources can only
        // appear once in and have only one parent.
        $resourceId = $resource->getResourceId();
        if(!empty($this->resources[$resourceId])){
            throw new InvalidResourceRelationship('Resource: '.$resourceId.' is part of multiple resource heirarchies.  This is currently not supported.');
        }

        $resource->getHierarchicalLevel($level);
        $this->resourceNames[] = $resourceId;

        if($parent){
            $resource->setParent($parent);
            $parent->addChild($resource);
        }

        return $this->resources[$resourceId] = $resource;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    protected function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $resources = $this->getRegisteredResources();
        $this->initializeResources($resources);
    }

    /**
     * @return string[]
     */
    public function getRegisteredResources()
    {
        $config = $this->getServiceLocator()->get('config');
        return $config['acl-resource'];
    }

    /**
     * @return string[]
     */
    public function getRegisteredResourceNames()
    {
        return $this->resourceNames;
    }

    /**
     * @return AbstractResource[]
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @return AbstractResource[]
     */
    public function getTopResources()
    {
        return $this->topResources;
    }

    /**
     * @param $resourceName
     * @return AbstractResource
     * @throws InvalidResourceName
     */
    public function get($resourceName)
    {
        if(empty($this->resources[$resourceName])){
            throw new InvalidResourceName('Resource ['.$resourceName.'] does not exist.');
        }
        return $this->resources[$resourceName];
    }

}