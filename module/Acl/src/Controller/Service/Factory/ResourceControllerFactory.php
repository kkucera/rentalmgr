<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/26/13
 */

namespace Acl\Controller\Service\Factory;

use Acl\Controller\Service\ResourceController;
use Acl\Marshal\ResourceToArray;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ResourceControllerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $controllerManager
     * @return ResourceController|mixed
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        /** @var ControllerManager $controllerManager */
        /** @var ServiceLocatorInterface $sm */
        $sm = $controllerManager->getServiceLocator();
        $resourceService = $sm->get('Acl\Service\Resource');
        $resourceFactory = $sm->get('Acl\Resource\Factory');
        $resourceToArray = new ResourceToArray;
        return new ResourceController($resourceService, $resourceFactory, $resourceToArray);
    }
}