<?php

namespace Events\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class EventsControllerFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $I_serviceLocator) {
		
	    // create dependencies
	    $I_eventService = $I_serviceLocator->getServiceLocator()->get('Events\Service\EventService');
	    
	    $as_countries = $I_eventService->getCountries();
	    $I_form = new \Events\Form\Promote($as_countries);
	    
	    $I_formFilter = new \Events\Form\PromoteFilter();
	    $I_form->setInputFilter($I_formFilter);
	    
	    return new \Events\Controller\EventsController($I_eventService, $I_form);
		
	}

}