<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kevin
 * Date: 8/29/13
 * Time: 9:09 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Property;

return array(
    'controllers' => array(
        'invokables' => array(
            'Property\Controller\Property' => 'Property\Controller\PropertyController',
            'Property\Controller\Service\Property' => 'Property\Controller\Service\PropertyController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'property' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/property[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Property\Controller\Property',
                        'action'     => 'index',
                    ),
                ),
            ),
            'property-service' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/service/property/:action[.:format][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Property\Controller\Service\Property',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'property' => __DIR__ . '/../view',
        ),
    ),

    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )
);