<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/2/13
 */
namespace Application;

return array(
    'factories' => array(
        'Application\DoctrineFactory' =>  function($sm) {
            $factory = new DoctrineFactory();
            $factory->setServiceLocator($sm);
            return $factory;
        },
    ),
);