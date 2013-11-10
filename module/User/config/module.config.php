<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kevin
 * Date: 8/29/13
 * Time: 9:09 PM
 * To change this template use File | Settings | File Templates.
 */
namespace User;

return array(
    'controllers' => array(
        'invokables' => array(
            'auth-login-controller' => 'Auth\Controller\LoginController',
            'auth-login-service-controller' => 'Auth\Controller\Service\AuthorizationController',

            'user-controller' => 'User\Controller\UserController',
            'user-service-controller' => 'User\Controller\Service\UserController',
        ),
        'initializers' => array(
            'Auth\Initializer\RequireAuthentication'
        )
    ),
    'service_manager' => array(
        'invokables' => array(
            'User\Service' => 'User\Service'
        )
    ),
    'router' => array(
        'routes' => array(
            'auth-login' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/login[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'auth-login-controller',
                        'action'     => 'index',
                    ),
                ),
            ),
            'auth-logout' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/logout[/]',
                    'defaults' => array(
                        'controller' => 'auth-login-controller',
                        'action'     => 'logout',
                    ),
                ),
            ),
            'authorization-service' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/authorization/service/:action[.:format][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'auth-login-service-controller',
                    ),
                ),
            ),
            'user' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        'controller' => 'user-controller',
                        'action'     => 'index',
                    )
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
                                'controller' => 'user-controller',
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
                                'controller' => 'user-service-controller',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
            'auth' => __DIR__ . '/../view',
        ),
    ),

    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
                )
            ),
            'Auth_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Auth/Entity',
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                    'Auth\Entity' => 'Auth_driver'
                )
            )
        )
    ),

    // acl resources
    'acl-resource' => array(
        'User\Resource\User'=>array(
            'User\Resource\User\View',
            'User\Resource\User\Create',
            'User\Resource\User\Edit',
            'User\Resource\User\Delete'
        )
    ),

    'navigation' => array(
        'default' => array(
            array(
                'label' => 'User',
                'route' => 'user',
                'resource' => new Resource\User,
                'order' => 200,
                'pages' => array(
                    array(
                        'label' => 'View',
                        'uri' => '/user/list',
                        'resource' => new Resource\User\View,
                    ),
                    array(
                        'label' => 'Create',
                        'uri' => '/user/add',
                        'resource' => new Resource\User\Create,
                    ),
                    array(
                        'label' => 'Edit',
                        'uri' => '/user/edit',
                        //'resource' => new Resource\User\Edit,
                    ),
                    array(
                        'label' => 'Delete',
                        'uri' => '/user/delete',
                        'resource' => new Resource\User\Delete,
                    ),
                ),
            ),
        ),
    ),
);