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
            'User\Controller\Login' => 'User\Controller\LoginController',
            'User\Controller\Service\User' => 'User\Controller\Service\UserController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'user-login' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/user/login[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\Login',
                        'action'     => 'index',
                    ),
                ),
            ),
            'user-logout' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/user/logout[/]',
                    'defaults' => array(
                        'controller' => 'User\Controller\Login',
                        'action'     => 'logout',
                    ),
                ),
            ),
            'user-service' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/service/user/:action[.:format][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\Service\User',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
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