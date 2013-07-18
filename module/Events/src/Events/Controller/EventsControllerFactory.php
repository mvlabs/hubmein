<?php

namespace Events\Controller;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

use Events\Form\PromoteFilter,
    Events\Form\Promote,
    Events\Controller\EventsController;

class EventsControllerFactory implements FactoryInterface {

    /**
     * Default method to be used in a Factory Class
     * 
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    // dependency is fetched from Service Manager
	    $eventService = $serviceLocator->getServiceLocator()->get('Events\Service\EventService');
	    $regionService = $serviceLocator->getServiceLocator()->get('Events\Service\RegionService');
	    // Object graph is constructed
	    $countries = $regionService->getListAsArray();
	    $form = new Promote($countries);
	    
	    $formFilter = new PromoteFilter();
	    $form->setInputFilter($formFilter);
	    
	    // Controller is constructed, dependencies are injected (IoC in action)
	    $controller = new EventsController($eventService, $regionService,$form); 
	    
	    return $controller; 
		
	}

}