<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/26/13
 */

namespace Acl\Service\Factory;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Acl\Service\UserResource as UserResourceService;

class UserResourceServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return UserResourceService|mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $resourceService = $serviceLocator->get('Acl\Service\Resource');
        return new UserResourceService($resourceService);
    }
}