<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 11/24/13
 */

namespace Organization\Controller\Factory;


use Organization\Controller\OrganizationServiceController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OrganizationServiceControllerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $controllerManager
     * @return OrganizationServiceController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        /** @var ControllerManager $controllerManager */
        /** @var ServiceLocatorInterface $sm */
        $sm = $controllerManager->getServiceLocator();
        $organizationService = $sm->get('Organization\Service');
        $addressService = $sm->get('Core\Service\Address');
        $phoneService = $sm->get('Core\Service\Phone');
        return new OrganizationServiceController($organizationService, $addressService, $phoneService);
    }

}