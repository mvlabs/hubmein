<?php

namespace Events\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class EventServiceFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
		
	    $mapper = $serviceLocator->get('Events\Mapper\EventMapper');
		return new EventService($mapper);
		
	}

}