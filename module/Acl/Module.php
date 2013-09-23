<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kevin
 * Date: 8/29/13
 * Time: 9:07 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Acl;

use Zend\Console\Adapter\AdapterInterface as Console;

class Module {
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src',
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return mixed
     */
    public function getServiceConfig()
    {
        return include __DIR__ . '/config/service.config.php';
    }

    public function getConsoleUsage(Console $console){
        return array(
            // Describe available commands
            'acl register resources [--verbose|-v]'    => 'Inserts all available resources into the database. Also validates ID uniqueness.',

            // Describe expected parameters
            array( '--verbose|-v',     '(optional) turn on verbose mode'        ),
        );
    }
}