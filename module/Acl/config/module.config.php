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
        'factories' => array(
            // console controllers
            'Acl\Controller\Console\Resource' => 'Acl\Controller\Console\Factory\ResourceControllerFactory',
            // service controllers
            'acl-controller-service-resource' => 'Acl\Controller\Service\Factory\ResourceControllerFactory',
            'acl-controller-service-user-resource' => 'Acl\Controller\Service\Factory\UserResourceControllerFactory',
            // application controllers
            'Acl\Controller\UserResource' => 'Acl\Controller\Factory\UserResourceControllerFactory'
        ),
        'invokables' => array(
            'Acl\Controller\Acl' => 'Acl\Controller\AclController',
            'Acl\Controller\Group' => 'Acl\Controller\GroupController',
            'Acl\Controller\UserGroup' => 'Acl\Controller\UserGroupController',
            // services
            'Acl\Controller\Service\Group' => 'Acl\Controller\Service\GroupController',
            'Acl\Controller\Service\UserGroup' => 'Acl\Controller\Service\UserGroupController',

        ),
        'initializers' => array(
            'Acl\Initializer\RequireZendAcl'
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Acl\Service\Resource' => 'Acl\Service\Factory\ResourceServiceFactory',
            'Acl\Service\UserResource' => 'Acl\Service\Factory\UserResourceServiceFactory',
            'Acl\Resource\Factory' => 'Acl\Resource\Factory\ResourceFactoryFactory',
        ),
        'invokables' => array(
            'Acl\Service\UserGroup' => 'Acl\Service\UserGroup',
            'Acl\Service\Group' => 'Acl\Service\Group',
            'Acl\Service\ZendAcl' => 'Acl\Service\ZendAcl',
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
                    'user-resource' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/user-resource[/:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Acl\Controller\UserResource',
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
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Acl\Controller\UserResource',
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
                                        'controller' => 'acl-controller-service-user-resource',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'resource' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route'    => '/resource',
                            'defaults' => array(
                                'controller' => 'acl-controller-resource',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'service' => array(
                                'type'    => 'segment',
                                'options' => array(
                                    'route'    => '/service/:action[.:format][/:id]',
                                    'constraints' => array(
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'acl-controller-service-resource',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),

        ),
    ),

    'view_helpers' => array(
        'invokables' => array(
            'resourceOptions' => 'Acl\View\Helper\ResourceOptions',
        )
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
        'Acl\Resource\Acl' => array(
            'Acl\Resource\Group' => array(
                'Acl\Resource\Group\View',
                'Acl\Resource\Group\Create',
                'Acl\Resource\Group\Edit',
                'Acl\Resource\Group\Delete',
            ),
        ),
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
                'order' => 100,
                'pages' => array(
                    array(
                        'label' => 'Group',
                        'uri' => '/acl/group',
                        'resource' => new Resource\Group,
                    ),
                    array(
                        'label' => 'User Group',
                        'uri' => '/acl/user-group',
                        'resource' => new Resource\Group,
                    ),
                    array(
                        'label' => 'User Permission',
                        'uri' => '/acl/user-resource',
                        'resource' => new Resource\ACL,
                    ),
                ),
            ),
        ),
    ),
);