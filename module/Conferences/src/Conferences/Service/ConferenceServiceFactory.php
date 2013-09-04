<?php

namespace Conferences\Service;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

use Conferences\Service\ConferenceService;

class ConferenceServiceFactory implements FactoryInterface {

    
	public function createService(ServiceLocatorInterface $serviceLocator) {
            
           $mapper = $serviceLocator->get('Conferences\Mapper\ConferenceMapper');
           
           return new ConferenceService($mapper);
		
	}
        

}