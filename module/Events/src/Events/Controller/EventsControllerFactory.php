<?php

namespace Events\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class EventsControllerFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $I_serviceLocator) {
		
	    // create dependencies
	    $I_form = new \Events\Form\Promote();
	    $I_formFilter = new \Events\Form\PromoteFilter();
	    $I_form->setInputFilter($I_formFilter);
	    	    	    
	    $I_eventService = $I_serviceLocator->getServiceLocator()->get('Events\Service\EventService');
	    
	    //reuse from phly contact
	    /*$I_eventsController->setMailTransport($sm->getServiceLocator()->get('PhlyContactMailTransport'));
	    
	    //reuse from phly contact
	    $I_eventsController->setMessage($sm->getServiceLocator()->get('PhlyContactMailMessage'));*/
	    
	    return new \Events\Controller\EventsController($I_eventService, $I_form);
		
	}

}