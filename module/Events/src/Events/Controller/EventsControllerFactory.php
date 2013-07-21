<?php

namespace Events\Controller;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

use Events\Form\PromoteFilter,
    Events\Form\Promote,
    Events\Controller\EventsController;

use Events\Service\EventService,
    Events\Service\RegionService,
    Events\Service\TagService;

class EventsControllerFactory implements FactoryInterface {

    /**
     * Default method to be used in a Factory Class
     * 
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    // Get $eventService, $regionService, $tagService
	    $eventService = $serviceLocator->getServiceLocator()->get( 'Events\Service\EventService' );
	    $regionService = $serviceLocator->getServiceLocator()->get( 'Events\Service\RegionService' );
            $tagService = $serviceLocator->getServiceLocator()->get( 'Events\Service\TagService' );
            
	    //@TODO why $regionService is not injected in the form constructor?
	    $countries = $regionService->getListAsArray();
	    $promoteForm = new Promote( $countries );
	    
	    $formFilter = new PromoteFilter();
	    $promoteForm->setInputFilter( $formFilter );
	    
	    // create  an instance of EventsController injecting $eventService, $regionService, $tagService, $promoteForm as dependencies (IoC in action)
	    $controller = new EventsController( $eventService, $regionService,  $tagService,  $promoteForm ); 
	    
	    return $controller; 
		
	}

}