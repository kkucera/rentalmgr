<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/1/13
 */

namespace Application;

use Application\Exception\ServiceLocatorNotSet;
use Zend\ServiceManager\Exception;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceLocator implements ServiceLocatorInterface{

    static $serviceLocator;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public static function register(ServiceLocatorInterface $serviceLocator){
        self::$serviceLocator = $serviceLocator;
    }

    /**
     *
     */
    public function __construct(ServiceLocatorInterface $serviceLocator = null)
    {
        if($serviceLocator){
            self::$serviceLocator = $serviceLocator;
        }
    }

    /**
     * Retrieve a registered instance
     *
     * @param string $name
     * @return array|object
     * @throws ServiceLocatorNotSet
     */
    public function get($name)
    {
        $serviceLocator = self::$serviceLocator;
        if(empty($serviceLocator)){
            throw new ServiceLocatorNotSet('\Application\ServiceLocator is merely a service locator wrapper.  You must construct the \Application\ServiceLocator with or register a valid service locator prior to calling get');
        }
        return $serviceLocator->get($name);
    }

    /**
     * Check for a registered instance
     *
     * @param array|string $name
     * @return bool
     * @throws ServiceLocatorNotSet
     */
    public function has($name)
    {
        if(empty($serviceLocator)){
            throw new ServiceLocatorNotSet('\Application\ServiceLocator is merely a service locator wrapper.  You must construct the \Application\ServiceLocator or register with a valid service locator prior to calling set');
        }
        return $serviceLocator->has($name);
    }
}