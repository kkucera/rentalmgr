<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/26/13
 */

namespace Acl\Resource\Factory;

use Acl\Resource\Factory as ResourceFactory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ResourceFactoryFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ResourceFactory
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ResourceFactory($serviceLocator);
    }
}