<?php

namespace Events\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class EventsControllerFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    // create dependencies
	    $eventService = $serviceLocator->getServiceLocator()->get('Events\Service\EventService');
	    
	    $countries = $eventService->getCountries();
	    $form = new \Events\Form\Promote($countries);
	    
	    $formFilter = new \Events\Form\PromoteFilter();
	    $form->setInputFilter($formFilter);
	    
	    return new \Events\Controller\EventsController($eventService, $form);
		
	}

}