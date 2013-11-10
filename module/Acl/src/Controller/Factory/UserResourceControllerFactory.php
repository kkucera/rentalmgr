<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/29/13
 */

namespace Acl\Controller\Factory;

use Acl\Controller\UserResourceController;
use Acl\Marshal\ResourceToArray;
use Acl\Marshal\UserGroupsWithResourceNamesToArray;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserResourceControllerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $controllerManager
     * @return UserResourceController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        /** @var ControllerManager $controllerManager */
        /** @var ServiceLocatorInterface $sm */
        $sm = $controllerManager->getServiceLocator();
        $resourceFactory = $sm->get('Acl\Resource\Factory');
        $userResourceService = $sm->get('Acl\Service\UserResource');
        $userService = $sm->get('User\Service');
        $userGroupService = $sm->get('Acl\Service\UserGroup');
        $groupsToArrayMarshaller = new UserGroupsWithResourceNamesToArray();
        return new UserResourceController(
            $resourceFactory,
            $userResourceService,
            $userService,
            $userGroupService,
            $groupsToArrayMarshaller
        );
    }

}