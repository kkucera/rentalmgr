<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/21/13
 */

namespace Acl\Controller\Console;

use Acl\Resource\Factory as ResourceFactory;
use Acl\Service\Resource as ResourceService;
use Application\Controller\AbstractConsoleController;

class ResourceController extends AbstractConsoleController
{

    /**
     * @var ResourceService
     */
    private $resourceService;

    /**
     * @var ResourceFactory;
     */
    private $resourceFactory;

    /**
     * @param ResourceService $resourceService
     * @param ResourceFactory $resourceFactory
     */
    public function __construct(ResourceService $resourceService, ResourceFactory $resourceFactory)
    {
        $this->resourceService = $resourceService;
        $this->resourceFactory = $resourceFactory;
    }

    /**
     * Populate the database with all available resources and permissions
     */
    public function registerResourcesAction()
    {
        $resourceNames = $this->resourceFactory->getRegisteredResourceNames();

        $resourceService = $this->resourceService;

        $resourceService->deleteAllResources();

        foreach($resourceNames as $resourceName){
            $resource = $this->resourceFactory->get($resourceName);
            $resourceService->save($resource->getEntity());
        }
    }
}