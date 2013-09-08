<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/5/13
 */

namespace Application\Logger;

use Application\ServiceLocator;
use Logger;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Factory implements ServiceLocatorAwareInterface
{
    /**
     * @var Factory
     */
    private static $instance;

    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     *
     */
    public function __construct()
    {

    }

    /**
     * @return Factory
     */
    private static function getInstance()
    {
        if (empty( self::$instance )) {

            $factory = new Factory();
            $factory->initialize();

            self::$instance = $factory;
        }

        return self::$instance;
    }

    /**
     * @return bool
     */
    private function initialize()
    {
        // Initializes every Logger using the settings in the Application config.
        Logger::configure($this->getConfig());
        return true;
    }

    /**
     * @return mixed[]
     */
    private function getConfig()
    {
        $config = $this->getServiceLocator()->get('config');
        return $config['logger'];
    }

    /**
     * @param mixed $instance
     * @return Logger
     */
    public static function get($instance)
    {
        if (is_object($instance)) {
            $logger = self::getInstance()->getLoggerByObject($instance);
        }
        else {
            $name = $instance;
            $logger = self::getInstance()->getLogger($name);
        }

        return $logger;
    }

    /**
     * @param string $name
     * @return string
     */
    private function normalizeLoggerName($name)
    {
        return str_replace('\\', '.', $name);
    }

    /**
     * @param string $name
     * @return Logger
     */
    private function getLogger($name)
    {
        $loggerName = $this->normalizeLoggerName($name);

        return Logger::getLogger($loggerName);
    }

    /**
     * @param object $instance
     * @return Logger
     */
    private function getLoggerByObject($instance)
    {
        $name = get_class($instance);

        return $this->getLogger($name);
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        if(empty($this->serviceLocator)){
            $this->serviceLocator = new ServiceLocator();
        }
        return $this->serviceLocator;
    }
}