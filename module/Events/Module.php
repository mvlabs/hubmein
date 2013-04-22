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
    				'Events\Mapper\EventMapper' => 'Events\Mapper\DoctrineEventMapper',
    				'Events\Form\PromoteFilter' => 'Events\Form\PromoteFilter',
    			),
    			'factories' => array(
  					'Events\Service\EventService' => 'Events\Service\EventServiceFactory',
    				'Events\Form\Promote' => 'Events\Form\PromoteFactory',
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
