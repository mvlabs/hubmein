<?php

namespace Events\Service;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

use Events\Service\EventService;

class EventServiceFactory implements FactoryInterface {

    
	public function createService(ServiceLocatorInterface $serviceLocator) {
            
           $mapper = $serviceLocator->get('Events\Mapper\EventMapper');
           
           return new EventService($mapper);
		
	}
        

}