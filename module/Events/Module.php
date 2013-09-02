<?php

namespace Events;

use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements ViewHelperProviderInterface
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    
    // Service Manager Configuration
    public function getServiceConfig() {
    	return array(
            'aliases'=>array(

                 'event.service'=>'Events\Service\EventService',
                 'event.doctrine.mapper'=> 'Events\Mapper\DoctrineEventMapper'

             ),
            'factories' => array(
                
                'Events\Service\RegionService' => 'Events\Service\RegionServiceFactory',
                'Events\Service\EventService' => 'Events\Service\EventServiceFactory',
                'Events\Service\TagService' => 'Events\Service\TagServiceFactory',

                // Events mapper
                'Events\Mapper\EventMapper' => 'Events\Mapper\DoctrineEventMapperFactory',
                'Events\Mapper\RegionMapper' => 'Events\Mapper\DoctrineRegionMapperFactory',
                //'Events\Mapper\EventMapper' => 'Events\Mapper\ZendDbEventMapperFactory'

                // Tags mapper
                'Events\Mapper\TagMapper' => 'Events\Mapper\DoctrineTagMapperFactory',
                //'Events\Mapper\EventMapper' => 'Events\Mapper\ZendDbEventMapperFactory'
            ),
    			
    	);
    }
    
    public function getControllerConfig() {
        
        return array(
            'factories' => array(
                'Events\Controller\Events' => 'Events\Controller\EventsControllerFactory',
                
                // Admin controllers
                'Events\Controller\AdminEvents' => 'Events\Controller\AdminEventsControllerFactory',
                'Events\Controller\AdminTags' => 'Events\Controller\AdminTagsControllerFactory',
            ),
        );
        
    } 
    
    
    public function getControllerPluginConfig()
    {
    	return array(
    		'invokables' => array(
    		    'getAndCheckNumericParam' => 'Events\Controller\Plugin\GetAndCheckNumericParam',
    		)
    	);
    }
    
    
    public function getViewHelperConfig()
    {
    	return array(
			'invokables' => array( 
                            
			    'cost' => 'Events\View\Helper\DisplayCost',
                            
			),
                        'factories' => array(
                            
                            'rightSideBar' => 'Events\View\Helper\RightSideBarFactory',
                            
                        ),
    	);
    }
    
}
