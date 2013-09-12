<?php
namespace Conferences;

return array(
    'router' => array(
        'routes' => array(
            'conferences' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/conferences',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Conferences\Controller',
                        'controller'    => 'Conference',
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
                                'region' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                              
                            ),
                        ),
                    ),
                    
                    'countfilter' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/count[/:region]',
                            'constraints' => array(
                                'region' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                              'action'=>'count'
                            ),
                        ),
                    ),
                  
                    'promote' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/promote',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Conferences\Controller',
                                'controller'    => 'Conference',
                                'action'        => 'promote',
                            ),
                        )
                    ),
                    'process' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/process',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Conferences\Controller',
                                'controller'    => 'Conference',
                                'action'        => 'process',
                            ),
                        )
                    ),
                    'thanks' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/thanks',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Conferences\Controller',
                                'controller'    => 'Conference',
                                'action'        => 'thankyou',
                            ),
                        )
                    ),
                ),
            ),
            'cfps' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/cfps',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Conferences\Controller',
                        'controller'    => 'Conference',
                        'action'        => 'showcallForPaper',
                        'activeCfp'     => true
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'regionfilter' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/:region',
                            'constraints' => array(
                                'region' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                              
                            ),
                        ),
                    ),
                    
                    'countfilter' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/count[/:region]',
                            'constraints' => array(
                                'region' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                              'action'=>'count'
                            ),
                        ),
                    ),
                ),
             ),
            'event' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/event',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Conferences\Controller',
                        'controller'    => 'Conference',
                        'action'        => 'event',
                    ),
                )
            ),
            
            'zfcadmin' => array(
                'child_routes' => array(
                    
                    'conferences' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/conferences',
                            'defaults' => array(
                                'controller' => 'Conferences\Controller\AdminConference',
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
                            
                            // Conference image
                            'image' => array(
                                'type' => 'Zend\Mvc\Router\Http\Segment',
                                'options' => array(
                                    'route'    => '/image/:id',
                                    'constraints' => array(
                                        'id'         => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                        'action'     => 'image',
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
                                'controller' => 'Conferences\Controller\AdminTags',
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
        
         'strategies' => array(
         
            'ViewJsonStrategy',
         
      ),
    ),
    
    // Admin panel navigation
    'navigation' => array(
        'admin' => array(
            'conferences' => array(
                'label' => 'Conferences',
                'route' => 'zfcadmin/conferences',
            ),
            'tags' => array(
                'label' => 'Tags',
                'route' => 'zfcadmin/tags',
            ),
        ),
    ),
    
    // Admin panel ACL
    'bjyauthorize' => array(
        'guards' => array(
            'BjyAuthorize\Guard\Controller' => array(
                
                // Enable access to ZFC User pages
                array('controller' => 'zfcuser', 'roles' => array()),
                
                array('controller' => 'Conferences\Controller\Conference', 'roles' => array()),
                // Only 'admin' users can view Admin home page
                array('controller' => 'ZfcAdmin\Controller\AdminController', 'roles' => array('admin')),
                
                // Restrict access to other pages to 'admin' users
                array('controller' => 'Conferences\Controller\AdminConference', 'roles' => array('admin')),
                array('controller' => 'Conferences\Controller\AdminTags', 'roles' => array('admin')),
            ),
        ),
    ),
    
);
