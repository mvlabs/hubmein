<?php

namespace Conferences\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Conferences\Form\Conference as ConferenceForm,
    Conferences\Form\ConferenceFilter,
    Conferences\Controller\AdminConferenceController;

class AdminConferenceControllerFactory implements FactoryInterface {

    /**
     * Default method to be used in a Factory Class
     * 
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    // dependency is fetched from Service Manager
	    $eventService = $serviceLocator->getServiceLocator()->get('Conferences\Service\ConferenceService');
	    $tagService = $serviceLocator->getServiceLocator()->get('Conferences\Service\TagService');
	    
	    // Object graph is constructed
        $objectManager = $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	    $tags = $tagService->getTagListAsArray();
	    $countries = $eventService->getCountryListAsArray();
	    $form = new ConferenceForm($objectManager, $tags, $countries);
	    
	    $formFilter = new ConferenceFilter();
	    $form->setInputFilter($formFilter);
	    
	    // Controller is constructed, dependencies are injected (IoC in action)
	    $controller = new AdminConferenceController($eventService, $form); 
	    
	    return $controller; 
		
	}

}