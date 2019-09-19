<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Backend\Controller',
                        'controller'    => 'User',
                        'action'     => 'dashboard',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /backend/:controller/:action
            'Product' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/product',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Backend\Controller',
                        'controller'    => 'Product',
                        'action'        => 'addProduct',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'index'
                            ),
                        ),
                    ),
                ),
            ),
            'StockAdjustment' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/stockadjustment',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Backend\Controller',
                        'controller'    => 'StockAdjustment',
                        'action'        => 'list',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'list'
                            ),
                        ),
                    ),

                    'details' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/details[/:orderid]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'details'
                            ),
                        ),
                    ),

                ),
            ),
           'PurchaseOrder' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/purchaseorder',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Backend\Controller',
                        'controller'    => 'PurchaseOrder',
                        'action'        => 'new',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'new'
                            ),
                        ),
                    ),
                    'cancel' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/cancel[/:orderid]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'cancel'
                            ),
                        ),
                    ),
                    'details' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/details[/:orderid]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'details'
                            ),
                        ),
                    ),
                    'markasdelivered' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/markasdelivered[/:orderid]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'markasdelivered'
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/edit[/:orderid]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'edit'
                            ),
                        ),
                    ),
                ),
            ),
            'Salesorder' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/salesorder',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Backend\Controller',
                        'controller'    => 'SalesOrder',
                        'action'        => 'new',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'new'
                            ),
                        ),
                    ),
                    'details' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/details[/:orderid]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'details'
                            ),
                        ),
                    ),
                    'markaspaid' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/markaspaid[/:orderid]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'markaspaid'
                            ),
                        ),
                    ),
                    'payments' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/payments[/:orderid]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'payments'
                            ),
                        ),
                    ),
                    'markasdelivered' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/markasdelivered[/:orderid]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'markasdelivered'
                            ),
                        ),
                    ),
                    'finalize' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/finalize[/:orderid]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'finalize'
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/edit[/:orderid]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'edit'
                            ),
                        ),
                    ),
                ),
            ),
            'Reports' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/reports',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Backend\Controller',
                        'controller'    => 'Reports',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'index'
                            ),
                        ),
                    ),
                    'daily' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/daily',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Backend\Controller',
                                'controller' => 'Reports',
                                'action'     => 'daily',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                ),
            ),
            'project' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/project',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Backend\Controller',
                        'controller'    => 'project',
                        'action'        => 'dashboard',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'index'
                            ),
                        ),
                    ),
                ),
            ),
            'User' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Backend\Controller',
                        'controller'    => 'User',
                        'action'        => 'dashboard',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'dashboard'
                            ),
                        ),
                    ),
                    'dashboard' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/dashboard',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Backend\Controller',
                                'controller' => 'User',
                                'action'     => 'dashboard',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                ),
            ),
            'Login' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Backend\Controller',
                        'controller'    => 'User',
                        'action'        => 'login',
                    ),
                ),
                'may_terminate' => true,
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),

    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Backend\Controller\Product' => 'Backend\Controller\ProductController',
            'Backend\Controller\Order'   => 'Backend\Controller\OrderController',
            'Backend\Controller\SalesOrder'   => 'Backend\Controller\SalesOrderController',
            'Backend\Controller\PurchaseOrder'   => 'Backend\Controller\PurchaseOrderController',
            'Backend\Controller\StockAdjustment'   => 'Backend\Controller\StockAdjustmentController',
            'Backend\Controller\User'   => 'Backend\Controller\UserController',
            'Backend\Controller\Project'   => 'Backend\Controller\ProjectController',
            'Backend\Controller\Reports'   => 'Backend\Controller\ReportsController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'base_path'                => '/',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'backend/index/index' => __DIR__ . '/../view/backend/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    'staticSalt' => "l4r!<@rB3n",
);
