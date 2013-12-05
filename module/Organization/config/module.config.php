<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 11/20/13
 */

namespace Organization;

return array(

    'controllers' => array(
        'factories' => array(
            // service controllers
            'organization-service-controller' => 'Organization\Controller\Factory\OrganizationServiceControllerFactory',
            // application controllers
            'organization-controller' => 'Organization\Controller\Factory\OrganizationControllerFactory',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'Organization\Service' => 'Organization\Service',
        ),
    ),
    'router' => array(
        'routes' => array(
            'organization' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/organization',
                    'defaults' => array(
                        'controller' => 'organization-controller',
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
                                'controller' => 'organization-controller',
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
                                'controller' => 'organization-service-controller',
                            ),
                        ),
                    ),
                ),
            ),

        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'organization' => __DIR__ . '/../view',
        ),
    ),

    // acl resources
    'acl-resource' => array(
        'Organization\Resource\Manage'
    ),

    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Organizations',
                'route' => 'organization',
                'resource' => new Resource\Manage,
                'order' => 300,
                'pages' => array(
                    array(
                        'label' => 'View',
                        'uri' => '/organization',
                        'resource' => new Resource\Manage,
                    ),
                    array(
                        'label' => 'Create',
                        'uri' => '/organization/edit',
                        'resource' => new Resource\Manage,
                    ),
                ),
            ),
        ),
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