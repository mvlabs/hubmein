<?php

namespace Events;

return array(
    'router' => array(
        'routes' => array(
            'events' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/events',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Events\Controller',
                        'controller'    => 'Events',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'regionfilter' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/:region',
                            'constraints' => array(
                                'region'         => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'search',
                            ),
                        ),
                    ),
                    'promote' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/promote',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Events\Controller',
                                'controller'    => 'Events',
                                'action'        => 'promote',
                            ),
                        )
                    ),
                    'process' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/process',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Events\Controller',
                                'controller'    => 'Events',
                                'action'        => 'process',
                            ),
                        )
                    ),
                    'thanks' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/thanks',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Events\Controller',
                                'controller'    => 'Events',
                                'action'        => 'thankyou',
                            ),
                        )
                    ),
                ),
            ),
            'event' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/event',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Events\Controller',
                        'controller'    => 'Events',
                        'action'        => 'event',
                    ),
                )
            ),
            
            'zfcadmin' => array(
                'child_routes' => array(
                    
                    'events' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/events',
                            'defaults' => array(
                                'controller' => 'Events\Controller\AdminEvents',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            
                            // Event CRUD route
                            'crud' => array(
                                'type' => 'Zend\Mvc\Router\Http\Segment',
                                'options' => array(
                                    'route'    => '/:action[/:id]',
                                    'constraints' => array(
                                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'         => '[0-9]*',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    
                    'tags' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/tags',
                            'defaults' => array(
                                'controller' => 'Events\Controller\AdminTags',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                    
                            // Tag CRUD route
                            'crud' => array(
                                'type' => 'Zend\Mvc\Router\Http\Segment',
                                'options' => array(
                                    'route'    => '/:action[/:id]',
                                    'constraints' => array(
                                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'         => '[0-9]*',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    
                ),
            ),
            
        ),
    ),
    
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
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
    // Admin panel navigation
    'navigation' => array(
        'admin' => array(
            'events' => array(
                'label' => 'Events',
                'route' => 'zfcadmin/events',
            ),
            'tags' => array(
                'label' => 'Tags',
                'route' => 'zfcadmin/tags',
            ),
        ),
    ),
    
);
