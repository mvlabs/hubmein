<?php

namespace Conferences\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Conferences\Form\Conference as ConferenceForm,
    Conferences\Form\ConferenceImage as ConferenceImageForm,
    Conferences\Form\ConferenceFilter,
    Conferences\Form\ConferenceImageFilter,
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
	    $tags = $tagService->getTagListAsArray();
	    $countries = $eventService->getCountryListAsArray();
	    $form = new ConferenceForm($tags, $countries);
	    
	    $formFilter = new ConferenceFilter();
	    $form->setInputFilter($formFilter);
        
        // Create form for image upload
        $imageForm = new ConferenceImageForm();
        
        $imageFormFilter = new ConferenceImageFilter();
	    $imageForm->setInputFilter($imageFormFilter);
	    
	    // Controller is constructed, dependencies are injected (IoC in action)
	    $controller = new AdminConferenceController($eventService, $form, $imageForm); 
	    
	    return $controller; 
		
	}

}