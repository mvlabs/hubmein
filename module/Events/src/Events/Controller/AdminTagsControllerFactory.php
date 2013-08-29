<?php

namespace Events\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class AdminTagsControllerFactory implements FactoryInterface {

    /**
     * Default method to be used in a Factory Class
     * 
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    // dependency is fetched from Service Manager
	    $tagService = $serviceLocator->getServiceLocator()->get('Events\Service\TagService');
	    
	    // Object graph is constructed
        $objectManager = $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	    $form = new \Events\Form\Tag($objectManager);
	    
	    $formFilter = new \Events\Form\TagFilter();
	    $form->setInputFilter($formFilter);
	    
	    // Controller is constructed, dependencies are injected (IoC in action)
	    $controller = new \Events\Controller\AdminTagsController($tagService, $form); 
	    
	    return $controller; 
		
	}

}