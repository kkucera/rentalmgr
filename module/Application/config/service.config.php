<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/2/13
 */
namespace Application;

use Application\Dao\DoctrineFactory;
use Zend\ServiceManager\ServiceManager;

return array(
    'factories' => array(
        'Application\Dao\DoctrineFactory' =>  function($sm) {
            $factory = new DoctrineFactory();
            $factory->setServiceLocator($sm);
            return $factory;
        },
        'Zend\Authentication\AuthenticationService' => function(ServiceManager $serviceManager) {
            return $serviceManager->get('doctrine.authenticationservice.orm_default');
        }
    ),
);