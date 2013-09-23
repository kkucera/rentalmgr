<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kevin
 * Date: 8/29/13
 * Time: 9:09 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Acl;

return array(
    'controllers' => array(
        'invokables' => array(
            'Acl\Controller\Acl' => 'Acl\Controller\AclController',
            'group' => 'Acl\Controller\GroupController',
            // services
            'Acl\Controller\Service\Group' => 'Acl\Controller\Service\GroupController',
            // console controllers
            'Acl\Controller\Console\Resource' => 'Acl\Controller\Console\ResourceController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'acl' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/acl/:controller[/:action][/:id]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Acl\Controller\Acl',
                        'action'     => 'index',
                    ),
                ),
            ),
            'acl-groups-service' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/service/acl/:controller/:action[.:format][/:id]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Acl\Controller\Service\Acl',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'acl' => __DIR__ . '/../view',
        ),
    ),


    'console' => array(
        'router' => array(
            'routes' => array(
                'resource-register' => array(
                    'options' => array(
                        'route'    => 'acl register resources',
                        'defaults' => array(
                            'controller' => 'Acl\Controller\Console\Resource',
                            'action'     => 'registerResources'
                        )
                    )
                )
            )
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

    // acl resources
    'acl-resource' => array(
        'Acl\Resource\Group'
    )
);