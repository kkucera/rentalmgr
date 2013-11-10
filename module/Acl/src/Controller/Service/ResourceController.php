<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/31/13
 */

namespace Acl\Controller\Service;

use Acl\Entity\Resource;
use Acl\Marshal\ResourceToArray;
use Acl\Resource\Factory as ResourceFactory;
use Acl\Service\Resource as ResourceService;
use Application\Controller\AbstractCrudServiceController;
use Zend\View\Model\JsonModel;

class ResourceController extends AbstractCrudServiceController
{
    /**
     * @var \Acl\Resource\Factory
     */
    private $resourceFactory;

    /**
     * @var ResourceService
     */
    private $resourceService;

    /**
     * @var ResourceToArray
     */
    private $resourceToArrayMarshaller;

    /**
     * @return Object
     */
    protected function getEntity()
    {
        return new Resource;
    }

    /**
     * @return ResourceService
     */
    protected function getEntityService()
    {
        return $this->getResourceService();
    }

    /**
     * @return ResourceFactory
     */
    protected function getResourceFactory()
    {
        return $this->resourceFactory;
    }

    /**
     * @return ResourceService
     */
    protected function getResourceService()
    {
        return $this->resourceService;
    }

    /**
     * @return ResourceToArray
     */
    protected function getResourceToArrayMarshaller()
    {
        return $this->resourceToArrayMarshaller;
    }

    /**
     * @param ResourceService $resourceService
     * @param ResourceFactory $resourceFactory
     * @param ResourceToArray $resourceToArray
     */
    public function __construct(
        ResourceService $resourceService,
        ResourceFactory $resourceFactory,
        ResourceToArray $resourceToArray)
    {
        $this->resourceService = $resourceService;
        $this->resourceFactory = $resourceFactory;
        $this->resourceToArrayMarshaller = $resourceToArray;
    }

    /**
     * @return JsonModel
     */
    public function getListAction()
    {
        $resources = $this->getResourceFactory()->getTopResources();
        $resourcesArray = array();
        foreach($resources as $resource){
            $resourcesArray[] = $this->getResourceToArrayMarshaller()->marshal($resource);
        }
        return new JsonModel(
            array('resources'=>$resourcesArray)
        );
    }
}