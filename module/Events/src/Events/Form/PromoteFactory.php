<?php

namespace Events\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class PromoteFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $I_serviceLocator) {
		
	    // create dependencies
		$I_eventService = $I_serviceLocator->get('Events\Service\EventService');
		$as_countries = $I_eventService->getCountries();
	    
	    return new \Events\Form\Promote($as_countries);
		
	}

}