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
                'Events\Controller\Events' => function ($sm) {
                    
                    $I_eventsController = new \Events\Controller\EventsController();
                    
                    $I_form = new \Events\Form\Promote();
                    $I_formFilter = new \Events\Form\PromoteFilter();
                    $I_form->setInputFilter($I_formFilter);
                    $I_eventsController->setForm($I_form);
                    
                    //reuse from phly contact
                    $I_eventsController->setMailTransport($sm->getServiceLocator()->get('PhlyContactMailTransport'));
                    
                    //reuse from phly contact
                    $I_eventsController->setMessage($sm->getServiceLocator()->get('PhlyContactMailMessage'));
                    
                    return $I_eventsController;
                }
            ),
        );
        
    } 
    
    public function getViewHelperConfig()
    {
    	return array(
    			'invokables' => array( 'cost' => 'Events\View\Helper\DisplayCost' ),
    	);
    }
    
}
