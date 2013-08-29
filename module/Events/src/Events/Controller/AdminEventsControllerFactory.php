<?php

namespace Events\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class AdminEventsControllerFactory implements FactoryInterface {

    /**
     * Default method to be used in a Factory Class
     * 
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    // dependency is fetched from Service Manager
	    $eventService = $serviceLocator->getServiceLocator()->get('Events\Service\EventService');
	    $tagService = $serviceLocator->getServiceLocator()->get('Events\Service\TagService');
	    
	    // Object graph is constructed
        $objectManager = $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	    $tags = $tagService->getTagListAsArray();
	    $countries = $eventService->getCountryListAsArray();
	    $form = new \Events\Form\Event($objectManager, $tags, $countries);
	    
	    $formFilter = new \Events\Form\EventFilter();
	    $form->setInputFilter($formFilter);
	    
	    // Controller is constructed, dependencies are injected (IoC in action)
	    $controller = new \Events\Controller\AdminEventsController($eventService, $form); 
	    
	    return $controller; 
		
	}

}