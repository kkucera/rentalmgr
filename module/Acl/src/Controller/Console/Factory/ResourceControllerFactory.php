<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/26/13
 */

namespace Acl\Controller\Console\Factory;

use Acl\Controller\Console\ResourceController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ResourceControllerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ControllerManager $controllerManager
     * @return ResourceController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $sm = $controllerManager->getServiceLocator();
        $resourceService = $sm->get('Acl\Service\Resource');
        $resourceFactory = $sm->get('Acl\Resource\Factory');
        return new ResourceController($resourceService, $resourceFactory);
    }
}