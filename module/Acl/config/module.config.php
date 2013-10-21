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
            'Acl\Controller\Group' => 'Acl\Controller\GroupController',
            'Acl\Controller\UserGroup' => 'Acl\Controller\UserGroupController',
            'Acl\Controller\UserPermission' => 'Acl\Controller\UserPermissionController',
            // services
            'Acl\Controller\Service\Group' => 'Acl\Controller\Service\GroupController',
            'Acl\Controller\Service\UserGroup' => 'Acl\Controller\Service\UserGroupController',
            'Acl\Controller\Service\UserPermission' => 'Acl\Controller\Service\UserPermissionController',
            // console controllers
            'Acl\Controller\Console\Resource' => 'Acl\Controller\Console\ResourceController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'acl' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/acl',
                    'defaults' => array(
                        'controller' => 'Acl\Controller\Acl',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'group' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route'    => '/group',
                            'defaults' => array(
                                'controller' => 'Acl\Controller\Group',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'action' => array(
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/:action[/:id]',
                                    'constraints' => array(
                                        'action' => '[^service][a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Acl\Controller\Group',
                                    ),
                                ),
                            ),
                            'service' => array(
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/service/:action[.:format][/:id]',
                                    'constraints' => array(
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Acl\Controller\Service\Group',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'user-group' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route'    => '/user-group',
                            'defaults' => array(
                                'controller' => 'Acl\Controller\UserGroup',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'action' => array(
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/:action[/:id]',
                                    'constraints' => array(
                                        'action' => '[^service][a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Acl\Controller\UserGroup',
                                    ),
                                ),
                            ),
                            'service' => array(
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/service/:action[.:format][/:id]',
                                    'constraints' => array(
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Acl\Controller\Service\UserGroup',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'user-permission' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route'    => '/user-permission',
                            'defaults' => array(
                                'controller' => 'Acl\Controller\UserPermission',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'action' => array(
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/:action[/:id]',
                                    'constraints' => array(
                                        'action' => '[^service][a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Acl\Controller\UserPermission',
                                    ),
                                ),
                            ),
                            'service' => array(
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/service/:action[.:format][/:id]',
                                    'constraints' => array(
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Acl\Controller\Service\UserPermission',
                                    ),
                                ),
                            ),
                        ),
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
        'Acl\Resource\Group' => array(
            'Acl\Resource\Group\View',
            'Acl\Resource\Group\Create'
        ),
        'Acl\Resource\Acl'
    ),

    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Home',
                'route' => 'home',
            ),
            array(
                'label' => 'Acl',
                'route' => 'acl',
                'resource' => new Resource\ACL,
                'pages' => array(
                    array(
                        'label' => 'Group',
                        'route' => 'acl/group',
                        'controller' => 'acl/group',
                        'action'     => 'index',
                        'resource' => new Resource\Group,
                    ),
                    array(
                        'label' => 'User Group',
                        'route' => 'acl/user-group',
                        'controller' => 'acl/user-group',
                        'action'     => 'index',
                        'resource' => new Resource\Group,
                    ),
                    array(
                        'label' => 'User Permission',
                        'route' => 'acl/user-permission',
                        'controller' => 'acl/user-permission',
                        'action'     => 'index',
                        'resource' => new Resource\Group\View,
                    ),
                ),
            ),
        ),
    ),
);