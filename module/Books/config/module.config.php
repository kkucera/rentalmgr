<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kevin
 * Date: 8/29/13
 * Time: 9:09 PM
 * To change this template use File | Settings | File Templates.
 */
namespace Books;

return array(
    'controllers' => array(
        'invokables' => array(
            'Books\Controller\Expense' => 'Books\Controller\ExpenseController',
            'Books\Controller\Service\Expense' => 'Books\Controller\Service\ExpenseController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'books' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/books/expense[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Books\Controller\Expense',
                        'action'     => 'index',
                    ),
                ),
            ),
            'books-service' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/service/books/expense[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Books\Controller\Service\Expense',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'books' => __DIR__ . '/../view',
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