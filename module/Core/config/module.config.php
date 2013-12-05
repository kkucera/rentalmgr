<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/26/13
 */

namespace Core;

return array(
    'service_manager' => array(
        'initializers' => array(
            'Core\Initializer\InterfaceInjection'
        ),
        'invokables' => array(
            'Core\Service\Address' => 'Core\Service\Address',
            'Core\Service\Phone' => 'Core\Service\Phone'
        ),
    ),
    'controllers' => array(
        'initializers' => array(
            'Core\Initializer\InterfaceInjection'
        )
    ),

    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Entity',
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                )
            )
        )
    ),

);