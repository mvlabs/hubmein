<?php

namespace Events\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class EventsControllerFactory implements FactoryInterface {

    /**
     * Default method to be used in a Factory Class
     * 
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    // dependency is fetched from Service Manager
	    $eventService = $serviceLocator->getServiceLocator()->get('Events\Service\EventService');
	    
	    // Object graph is constructed
	    $countries = $eventService->getCountries();
	    $form = new \Events\Form\Promote($countries);
	    
	    $formFilter = new \Events\Form\PromoteFilter();
	    $form->setInputFilter($formFilter);
	    
	    // Controller is constructed, dependencies are injected (IoC in action)
	    $controller = new \Events\Controller\EventsController($eventService, $form); 
	    
	    return $controller; 
		
	}

}