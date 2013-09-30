<?php

namespace Conferences\Controller;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

use Conferences\Form\PromoteFilter,
    Conferences\Form\Promote as PromoteForm,
    Conferences\Controller\ConferenceController;

class ConferenceControllerFactory implements FactoryInterface {

    /**
     * Default method to be used in a Factory Class
     * 
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     * @param Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     */
	public function createService(ServiceLocatorInterface $serviceLocator) {
			    
	    $conferenceService = $serviceLocator->getServiceLocator()->get('Conferences\Service\ConferenceService');
	    $regionService = $serviceLocator->getServiceLocator()->get('Conferences\Service\RegionService');
                    	    
	    $countries = $regionService->getListAsArray();
	    $promoteForm = new PromoteForm($countries);
	    $formFilter = new PromoteFilter();
	    $promoteForm->setInputFilter($formFilter);
	        
	    $conferenceController = new ConferenceController($conferenceService, $promoteForm); 
	    
	    return $conferenceController; 
		
	}

}