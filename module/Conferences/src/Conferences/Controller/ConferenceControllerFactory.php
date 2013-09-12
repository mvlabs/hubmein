<?php

namespace Conferences\Controller;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

use Conferences\Form\PromoteFilter,
    Conferences\Form\Promote,
    Conferences\Controller\ConferenceController;

class ConferenceControllerFactory implements FactoryInterface {

    /**
     * Default method to be used in a Factory Class
     * 
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    // Get $conferenceService, $regionService, $tagService
	    $conferenceService = $serviceLocator->getServiceLocator()->get( 'Conferences\Service\ConferenceService' );
	    $regionService = $serviceLocator->getServiceLocator()->get( 'Conferences\Service\RegionService' );
            $tagService = $serviceLocator->getServiceLocator()->get( 'Conferences\Service\TagService' );
            	    
	    $countries = $regionService->getListAsArray();
	    $promoteForm = new Promote( $countries );
	    $formFilter = new PromoteFilter();
	    $promoteForm->setInputFilter( $formFilter );
	    
	    // create  an instance of ConferencesController injecting $conferenceService, $regionService, $tagService, $promoteForm as dependencies (IoC in action)
	    $controller = new ConferenceController( $conferenceService, $regionService,  $tagService,  $promoteForm ); 
	    
	    return $controller; 
		
	}

}