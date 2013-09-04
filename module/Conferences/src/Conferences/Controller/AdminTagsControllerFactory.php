<?php

namespace Conferences\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Conferences\Form\Tag as TagForm,
    Conferences\Form\TagFilter;

use Conferences\Controller\AdminTagsController;

class AdminTagsControllerFactory implements FactoryInterface {

    /**
     * Default method to be used in a Factory Class
     * 
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    // dependency is fetched from Service Manager
	    $tagService = $serviceLocator->getServiceLocator()->get('Conferences\Service\TagService');
	    
	    // Object graph is constructed
        $objectManager = $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	    $form = new TagForm($objectManager);
	    
	    $formFilter = new TagFilter();
	    $form->setInputFilter($formFilter);
	    
	    // Controller is constructed, dependencies are injected (IoC in action)
	    $controller = new AdminTagsController($tagService, $form); 
	    
	    return $controller; 
		
	}

}