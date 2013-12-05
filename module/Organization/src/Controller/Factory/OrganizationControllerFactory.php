<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 11/24/13
 */

namespace Organization\Controller\Factory;

use Organization\Controller\OrganizationController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OrganizationControllerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $controllerManager
     * @return OrganizationController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        /** @var ControllerManager $controllerManager */
        /** @var ServiceLocatorInterface $sm */
        $sm = $controllerManager->getServiceLocator();
        $organizationService = $sm->get('Organization\Service');
        return new OrganizationController($organizationService);
    }

}