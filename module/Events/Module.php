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
    			'invokables' => array(
    			    'Events\Mapper\EventMapper' => 'Events\Mapper\DoctrineEventMapper'
    			),
    			'factories' => array(
  					'Events\Service\EventService' => 'Events\Service\EventServiceFactory',  
    			),
    	);
    }
    
    public function getControllerConfig() {
        
        return array(
            'factories' => array(
                'Events\Controller\Events' => 'Events\Controller\EventsControllerFactory',
            ),
        );
        
    } 
    
    public function getViewHelperConfig()
    {
    	return array(
			'invokables' => array( 
			    'cost' => 'Events\View\Helper\DisplayCost',
			),
    	    'factories' => array(
    	        'countries' => 'Events\View\Helper\DisplayCountrySelectFieldFactory',
    	    ),
    	);
    }
    
}
