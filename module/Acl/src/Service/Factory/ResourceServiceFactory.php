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
use Acl\Service\Resource as ResourceService;
use Acl\Resource\Factory as ResourceFactory;

class ResourceServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ResourceService|mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Acl\Resource\Factory $resourceFactory */
        $resourceFactory = $serviceLocator->get('Acl\Resource\Factory');
        return  new ResourceService($resourceFactory);
    }
}