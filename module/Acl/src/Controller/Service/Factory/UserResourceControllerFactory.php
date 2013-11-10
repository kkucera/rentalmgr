<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/26/13
 */

namespace Acl\Controller\Service\Factory;

use Acl\Controller\Service\UserResourceController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserResourceControllerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $controllerManager
     * @return UserResourceController|mixed
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        /** @var ControllerManager $controllerManager */
        /** @var ServiceLocatorInterface $sm */
        $sm = $controllerManager->getServiceLocator();
        $userResourceService = $sm->get('Acl\Service\UserResource');
        $resourceService = $sm->get('Acl\Service\Resource');
        return new UserResourceController($resourceService, $userResourceService);
    }
}